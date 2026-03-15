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
        $completedUpdates = PatientHealthUpdate::when(
            $nurseId,
            fn ($query) => $query->where('nurse_id', $nurseId)
        )->count();

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
        $healthUpdates = PatientHealthUpdate::where('patient_id', $patient->id)
            ->orderBy('recorded_at', 'desc')
            ->paginate(10);

        return view('nurse.patient-detail', compact('patient', 'healthUpdates'));
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

    public function communityHealthStatus()
    {
        $totalPatients = Patient::count();
        $recentUpdates = PatientHealthUpdate::orderBy('recorded_at', 'desc')
            ->limit(20)
            ->get();

        return view('nurse.community-health', compact('totalPatients', 'recentUpdates'));
    }
}
