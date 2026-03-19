<?php

namespace App\Http\Controllers;

use App\Models\MedicalAdvice;
use App\Models\MedicalReport;
use App\Models\HealthIncident;
use App\Models\PatientHealthUpdate;
use App\Support\DateInput;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;

        $recentRequests = HealthIncident::with(['patient.user', 'medicalAdvice.doctor.user'])
            ->where('request_channel', 'incident')
            ->prioritizeAdviceQueue()
            ->orderBy('reported_at', 'desc')
            ->limit(10)
            ->get();

        $pendingRequests = HealthIncident::whereIn('status', ['reported', 'under_review'])
            ->where('request_channel', 'incident')
            ->doesntHave('medicalAdvice')
            ->count();
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

    public function provideMedicalAdvice(HealthIncident $incident)
    {
        if ($incident->request_channel !== 'incident') {
            abort(404);
        }

        $incident->load(['patient.user', 'medicalAdvice.doctor.user']);

        if ($incident->medicalAdvice) {
            return redirect()->route('doctor.view-advice', $incident->medicalAdvice)
                ->with('info', 'Medical advice has already been provided for this assistance request.');
        }

        $patient = $incident->patient;

        $recentIncidents = HealthIncident::where('patient_id', $patient->id)
            ->where('id', '!=', $incident->id)
            ->orderBy('reported_at', 'desc')
            ->limit(5)
            ->get();

        $latestHealthUpdate = PatientHealthUpdate::with('nurse.user')
            ->where('patient_id', $patient->id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        return view('doctor.provide-advice', compact('incident', 'patient', 'recentIncidents', 'latestHealthUpdate'));
    }

    public function storeMedicalAdvice(Request $request, HealthIncident $incident)
    {
        if ($incident->request_channel !== 'incident') {
            abort(404);
        }

        $request->merge([
            'follow_up_date' => DateInput::normalize($request->input('follow_up_date')),
        ]);

        $existingAdvice = MedicalAdvice::where('health_incident_id', $incident->id)->first();

        if ($existingAdvice) {
            return redirect()->route('doctor.view-advice', $existingAdvice)
                ->with('info', 'Medical advice has already been submitted for this assistance request.');
        }

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'recommendations' => 'nullable|string',
            'medication' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after:today',
        ]);

        $advice = "Diagnosis: {$validated['diagnosis']}\n\nTreatment Plan: {$validated['treatment_plan']}";

        if (!empty($validated['recommendations'])) {
            $advice .= "\n\nRecommendations: {$validated['recommendations']}";
        }

        MedicalAdvice::create([
            'patient_id' => $incident->patient_id,
            'health_incident_id' => $incident->id,
            'doctor_id' => auth()->user()->doctor->id,
            'advice' => $advice,
            'medication' => $validated['medication'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? null,
        ]);

        $incident->update([
            'status' => 'resolved',
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Medical advice provided successfully');
    }

    public function viewMedicalAdvice(MedicalAdvice $advice)
    {
        if ($advice->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        $advice->load(['patient.user', 'healthIncident']);

        return view('doctor.view-advice', compact('advice'));
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
