<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\HealthAlert;
use App\Models\HealthIncident;
use App\Models\PatientHealthUpdate;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function dashboard()
    {
        $patients = Patient::with('user')->paginate(15);
        $patientCount = Patient::count();
        $pendingReports = HealthIncident::whereIn('status', ['reported', 'under_review'])->count();
        $criticalAlerts = HealthAlert::where('severity', 'critical')->count();

        $nurseId = auth()->user()->nurse?->id;
        $completedUpdates = $nurseId
            ? PatientHealthUpdate::where('nurse_id', $nurseId)->count()
            : 0;

        return view('nurse.dashboard', compact(
            'patients',
            'patientCount',
            'pendingReports',
            'criticalAlerts',
            'completedUpdates'
        ));
    }

    public function viewPatients()
    {
        $patients = Patient::with('user')
            ->paginate(20);

        return view('nurse.patients', compact('patients'));
    }

    public function viewPatientDetail(Patient $patient)
    {
        $healthHistory = PatientHealthUpdate::where('patient_id', $patient->id)
            ->orderBy('recorded_at', 'desc')
            ->paginate(10);

        $latestHealthUpdate = PatientHealthUpdate::where('patient_id', $patient->id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        return view('nurse.patient-detail', compact('patient', 'healthHistory', 'latestHealthUpdate'));
    }

    public function updatePatientHealth(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|integer|min:0|max:300',
            'temperature' => 'nullable|numeric|min:30|max:45',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'notes' => 'nullable|string',
        ]);

        PatientHealthUpdate::create([
            'patient_id' => $patient->id,
            'nurse_id' => auth()->user()->nurse->id,
            'blood_pressure' => $validated['blood_pressure'] ?? null,
            'heart_rate' => $validated['heart_rate'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'height' => $validated['height'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'recorded_at' => now(),
        ]);

        return redirect()->route('nurse.patient-detail', $patient)->with('success', 'Patient health data updated successfully');
    }

    public function storeHealthAlert(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'alert_type' => 'required|string',
            'message' => 'required|string|max:1000',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        HealthAlert::create([
            'patient_id' => $patient->id,
            'alert_type' => $validated['alert_type'],
            'message' => $validated['message'],
            'severity' => $validated['severity'],
            'is_read' => false,
        ]);

        return redirect()->route('nurse.patient-detail', $patient)
            ->with('success', 'Health alert sent to patient successfully.');
    }

    public function communityHealthStatus()
    {
        $totalPatients = Patient::count();

        $criticalCases = HealthIncident::where('severity', 'critical')
            ->whereIn('status', ['reported', 'under_review'])
            ->count();

        $pendingUpdates = Patient::doesntHave('healthUpdates')->count();

        $criticalPatientsCount = HealthIncident::where('severity', 'critical')
            ->whereIn('status', ['reported', 'under_review'])
            ->distinct('patient_id')
            ->count('patient_id');

        $healthyPercentage = $totalPatients > 0
            ? (int) round((($totalPatients - min($criticalPatientsCount, $totalPatients)) / $totalPatients) * 100)
            : 0;

        $communityStats = [
            'total_patients' => $totalPatients,
            'critical_cases' => $criticalCases,
            'pending_updates' => $pendingUpdates,
            'healthy' => $healthyPercentage,
        ];

        $commonIssues = HealthIncident::selectRaw('incident_type, COUNT(*) as total')
            ->groupBy('incident_type')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn ($issue) => [
                'name' => ucfirst(str_replace('_', ' ', $issue->incident_type)),
                'count' => (int) $issue->total,
            ])
            ->values()
            ->all();

        $criticalIncidents = HealthIncident::with('patient.user')
            ->whereIn('severity', ['critical', 'high'])
            ->whereIn('status', ['reported', 'under_review'])
            ->orderByRaw("CASE severity WHEN 'critical' THEN 2 ELSE 1 END DESC")
            ->orderBy('reported_at', 'desc')
            ->limit(8)
            ->get();

        $patientsWithDob = Patient::whereNotNull('date_of_birth')->get();
        $patientsWithDobCount = $patientsWithDob->count();

        $childrenCount = $patientsWithDob->filter(fn ($patient) => $patient->age !== null && $patient->age <= 12)->count();
        $teensCount = $patientsWithDob->filter(fn ($patient) => $patient->age !== null && $patient->age >= 13 && $patient->age <= 19)->count();
        $adultsCount = $patientsWithDob->filter(fn ($patient) => $patient->age !== null && $patient->age >= 20 && $patient->age <= 59)->count();
        $seniorsCount = $patientsWithDob->filter(fn ($patient) => $patient->age !== null && $patient->age >= 60)->count();

        $ageGroups = [
            'children' => $patientsWithDobCount > 0 ? (int) round(($childrenCount / $patientsWithDobCount) * 100) : 0,
            'teens' => $patientsWithDobCount > 0 ? (int) round(($teensCount / $patientsWithDobCount) * 100) : 0,
            'adults' => $patientsWithDobCount > 0 ? (int) round(($adultsCount / $patientsWithDobCount) * 100) : 0,
            'seniors' => $patientsWithDobCount > 0 ? (int) round(($seniorsCount / $patientsWithDobCount) * 100) : 0,
        ];

        return view('nurse.community-health', compact('communityStats', 'commonIssues', 'criticalIncidents', 'ageGroups'));
    }

    public function viewAssistanceRequests()
    {
        $incidents = HealthIncident::with(['patient.user', 'medicalAdvice.doctor.user'])
            ->where('request_channel', 'assistance')
            ->orderByRaw("CASE status WHEN 'reported' THEN 1 WHEN 'under_review' THEN 2 WHEN 'resolved' THEN 3 ELSE 4 END ASC")
            ->orderBySeverityDesc()
            ->orderBy('reported_at', 'desc')
            ->paginate(20);

        return view('nurse.assistance-requests', compact('incidents'));
    }

    public function approveAssistanceRequest(HealthIncident $incident)
    {
        if ($incident->request_channel !== 'assistance') {
            abort(404);
        }

        if ($incident->status !== 'resolved') {
            $incident->update([
                'status' => 'resolved',
            ]);
        }

        return back()->with('success', 'Assistance request approved successfully.');
    }

    public function viewIncidentDetail(HealthIncident $incident)
    {
        if ($incident->request_channel !== 'assistance') {
            abort(404);
        }

        $incident->load(['patient.user', 'medicalAdvice.doctor.user']);

        return view('nurse.incident-detail', compact('incident'));
    }
}
