<?php

namespace App\Http\Controllers;

use App\Models\HealthAlert;
use App\Models\HealthIncident;
use App\Models\MedicalAdvice;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;

        $totalIncidentsCount = HealthIncident::where('patient_id', $patient->id)->count();
        $resolvedIncidentsCount = HealthIncident::where('patient_id', $patient->id)
            ->where('status', 'resolved')
            ->count();

        $healthAlerts = HealthAlert::where('patient_id', $patient->id)
            ->where('is_read', false)
            ->orderByRaw("CASE severity WHEN 'critical' THEN 4 WHEN 'high' THEN 3 WHEN 'medium' THEN 2 ELSE 1 END DESC")
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $healthIncidents = HealthIncident::with('medicalAdvice')
            ->where('patient_id', $patient->id)
            ->orderBySeverityDesc()
            ->orderBy('reported_at', 'desc')
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact(
            'patient',
            'healthAlerts',
            'healthIncidents',
            'totalIncidentsCount',
            'resolvedIncidentsCount'
        ));
    }

    public function requestAssistance()
    {
        return view('patient.request-assistance');
    }

    public function storeAssistance(Request $request)
    {
        $validated = $request->validate([
            'request_type' => 'required|in:home_visit,medication_assistance,medical_supply,follow_up_care,transport_assistance,other',
            'description' => 'required|string',
            'symptoms' => 'nullable|string',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $patient = auth()->user()->patient;

        HealthIncident::create([
            'patient_id' => $patient->id,
            'incident_type' => $validated['request_type'],
            'request_channel' => 'assistance',
            'description' => $validated['description'],
            'symptoms' => $validated['symptoms'] ?? null,
            'severity' => $validated['severity'],
            'reported_at' => now(),
            'status' => 'reported',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Medical assistance request submitted successfully. A nurse will review it.');
    }

    public function reportIncident()
    {
        return view('patient.report-incident');
    }

    public function storeIncident(Request $request)
    {
        $validated = $request->validate([
            'incident_type' => 'required|in:injury,illness,emergency,follow_up,medication_issue,other',
            'description' => 'required|string',
            'symptoms' => 'nullable|string',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $patient = auth()->user()->patient;

        HealthIncident::create([
            'patient_id' => $patient->id,
            'incident_type' => $validated['incident_type'],
            'request_channel' => 'incident',
            'description' => $validated['description'],
            'symptoms' => $validated['symptoms'] ?? null,
            'severity' => $validated['severity'],
            'reported_at' => now(),
            'status' => 'reported',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Health incident reported successfully');
    }

    public function viewAlerts()
    {
        $patient = auth()->user()->patient;
        $filter = request('filter', 'all');

        $alertsQuery = HealthAlert::where('patient_id', $patient->id);
        if ($filter === 'unread') {
            $alertsQuery->where('is_read', false);
        }

        $alerts = $alertsQuery
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('patient.alerts', compact('alerts', 'filter'));
    }

    public function markAlertAsRead(HealthAlert $alert)
    {
        if ($alert->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }

        $alert->update(['is_read' => true]);

        return back()->with('success', 'Alert marked as read');
    }

    public function viewMedicalAdvice()
    {
        $patient = auth()->user()->patient;

        $advices = MedicalAdvice::with(['doctor.user', 'healthIncident'])
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('patient.medical-advice', compact('advices'));
    }

    public function viewIncident(HealthIncident $incident)
    {
        if ($incident->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }

        $incident->load(['medicalAdvice.doctor.user']);

        return view('patient.incident-detail', compact('incident'));
    }
}
