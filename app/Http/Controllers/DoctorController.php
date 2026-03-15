<?php

namespace App\Http\Controllers;

use App\Models\MedicalAdvice;
use App\Models\MedicalReport;
use App\Models\HealthIncident;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;

        $recentRequests = HealthIncident::with('patient.user')
            ->whereIn('status', ['reported', 'under_review'])
            ->orderBy('reported_at', 'desc')
            ->limit(10)
            ->get();

        $pendingRequests = HealthIncident::whereIn('status', ['reported', 'under_review'])->count();
        $reportsForApproval = MedicalReport::where('status', 'pending')->count();
        $advicesGiven = MedicalAdvice::where('doctor_id', $doctor->id)->count();
        $patientsConsulted = MedicalAdvice::where('doctor_id', $doctor->id)
            ->distinct('patient_id')
            ->count('patient_id');

        return view('doctor.dashboard', compact(
            'recentRequests',
            'pendingRequests',
            'reportsForApproval',
            'advicesGiven',
            'patientsConsulted'
        ));
    }

    public function provideMedicalAdvice(Patient $patient)
    {
        $recentIncidents = HealthIncident::where('patient_id', $patient->id)
            ->orderBy('reported_at', 'desc')
            ->limit(5)
            ->get();

        return view('doctor.provide-advice', compact('patient', 'recentIncidents'));
    }

    public function storeMedicalAdvice(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'advice' => 'required|string',
            'medication' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after:today',
        ]);

        MedicalAdvice::create([
            'patient_id' => $patient->id,
            'doctor_id' => auth()->user()->doctor->id,
            'advice' => $validated['advice'],
            'medication' => $validated['medication'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? null,
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Medical advice provided successfully');
    }

    public function approveReport(MedicalReport $report)
    {
        $this->authorize('approve', $report);

        return view('doctor.approve-report', compact('report'));
    }

    public function storeReportApproval(Request $request, MedicalReport $report)
    {
        $this->authorize('approve', $report);

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        if ($validated['status'] === 'approved') {
            $report->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        } else {
            $report->update([
                'status' => 'rejected',
            ]);
        }

        return redirect()->route('doctor.dashboard')->with('success', 'Report ' . $validated['status'] . ' successfully');
    }

    public function viewReports()
    {
        $reports = MedicalReport::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('doctor.reports', compact('reports'));
    }

    public function createReport(HealthIncident $incident)
    {
        return view('doctor.create-report', compact('incident'));
    }

    public function storeReport(Request $request, HealthIncident $incident)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
        ]);

        MedicalReport::create([
            'patient_id' => $incident->patient_id,
            'doctor_id' => auth()->user()->doctor->id,
            'health_incident_id' => $incident->id,
            'diagnosis' => $validated['diagnosis'],
            'treatment_plan' => $validated['treatment_plan'],
            'status' => 'pending',
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Medical report created and submitted for approval');
    }
}
