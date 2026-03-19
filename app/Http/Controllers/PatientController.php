<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\HealthAlert;
use App\Models\HealthIncident;
use App\Models\MedicalAdvice;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;
        $healthAlerts = HealthAlert::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentAdvices = MedicalAdvice::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $healthIncidents = HealthIncident::where('patient_id', $patient->id)
            ->orderBy('reported_at', 'desc')
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('patient', 'healthAlerts', 'healthIncidents', 'recentAdvices'));
    }

    public function requestAssistance()
    {
        return view('patient.request-assistance');
    }

    public function storeAssistance(Request $request)
    {
        $validated = $request->validate([
            'incident_type' => 'required|string',
            'description' => 'required|string',
            'symptoms' => 'nullable|string',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $patient = auth()->user()->patient;

        HealthIncident::create([
            'patient_id' => $patient->id,
            'incident_type' => $validated['incident_type'],
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

        $advices = MedicalAdvice::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('patient.medical-advice', compact('advices'));
    }
}
