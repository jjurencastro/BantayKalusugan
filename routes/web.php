<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\BarangayAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated users dashboard (role-based redirect)
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    return match($user->role) {
        'patient' => redirect()->route('patient.dashboard'),
        'nurse' => redirect()->route('nurse.dashboard'),
        'doctor' => redirect()->route('doctor.dashboard'),
        'barangay_admin' => redirect()->route('admin.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'active', 'verified'])->name('dashboard');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Patient Routes
Route::middleware(['auth', 'active', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/medical-advice', [PatientController::class, 'viewMedicalAdvice'])->name('patient.medical-advice');
    Route::get('/patient/incidents/{incident}', [PatientController::class, 'viewIncident'])->name('patient.incidents.show');
    Route::get('/patient/request-assistance', [PatientController::class, 'requestAssistance'])->name('patient.request-assistance');
    Route::post('/patient/request-assistance', [PatientController::class, 'storeAssistance'])->name('patient.store-assistance');
    Route::get('/patient/report-incident', [PatientController::class, 'reportIncident'])->name('patient.report-incident');
    Route::post('/patient/report-incident', [PatientController::class, 'storeIncident'])->name('patient.store-incident');
    Route::get('/patient/alerts', [PatientController::class, 'viewAlerts'])->name('patient.alerts');
    Route::patch('/patient/alerts/{alert}', [PatientController::class, 'markAlertAsRead'])->name('patient.mark-alert-read');
});

// Nurse Routes
Route::middleware(['auth', 'active', 'role:nurse'])->group(function () {
    Route::get('/nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse.dashboard');
    Route::get('/nurse/patients', [NurseController::class, 'viewPatients'])->name('nurse.patients');
    Route::get('/nurse/patient/{patient}', [NurseController::class, 'viewPatientDetail'])->name('nurse.patient-detail');
    Route::post('/nurse/patient/{patient}/update-health', [NurseController::class, 'updatePatientHealth'])->name('nurse.update-patient-health');
    Route::get('/nurse/community-health', [NurseController::class, 'communityHealthStatus'])->name('nurse.community-health');
    Route::post('/nurse/patient/{patient}/alert', [NurseController::class, 'storeHealthAlert'])->name('nurse.store-health-alert');
    Route::get('/nurse/assistance-requests', [NurseController::class, 'viewAssistanceRequests'])->name('nurse.assistance-requests');
    Route::patch('/nurse/assistance-requests/{incident}/approve', [NurseController::class, 'approveAssistanceRequest'])->name('nurse.approve-assistance-request');
    Route::get('/nurse/assistance-requests/{incident}', [NurseController::class, 'viewIncidentDetail'])->name('nurse.incident-detail');
});

// Doctor Routes
Route::middleware(['auth', 'active', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/advice/{incident}', [DoctorController::class, 'provideMedicalAdvice'])->name('doctor.provide-advice');
    Route::post('/doctor/advice/{incident}', [DoctorController::class, 'storeMedicalAdvice'])->name('doctor.store-advice');
    Route::get('/doctor/advice-record/{advice}', [DoctorController::class, 'viewMedicalAdvice'])->name('doctor.view-advice');
    Route::get('/doctor/reports', [DoctorController::class, 'viewReports'])->name('doctor.reports');
    Route::get('/doctor/report/{report}/approve', [DoctorController::class, 'approveReport'])->name('doctor.approve-report');
    Route::patch('/doctor/report/{report}/approve', [DoctorController::class, 'storeReportApproval'])->name('doctor.store-approval');
    Route::get('/doctor/report/{incident}/create', [DoctorController::class, 'createReport'])->name('doctor.create-report');
    Route::post('/doctor/report/{incident}/create', [DoctorController::class, 'storeReport'])->name('doctor.store-report');
});

// Barangay Admin Routes
Route::middleware(['auth', 'active', 'role:barangay_admin'])->group(function () {
    Route::get('/admin/dashboard', [BarangayAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [BarangayAdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/user/{user}/edit', [BarangayAdminController::class, 'editUser'])->name('admin.edit-user');
    Route::patch('/admin/user/{user}', [BarangayAdminController::class, 'updateUser'])->name('admin.update-user');
    Route::patch('/admin/user/{user}/toggle-status', [BarangayAdminController::class, 'toggleUserStatus'])->name('admin.toggle-user-status');
    Route::delete('/admin/user/{user}', [BarangayAdminController::class, 'deleteUser'])->name('admin.delete-user');
    Route::get('/admin/health-reports', [BarangayAdminController::class, 'healthReports'])->name('admin.health-reports');
    Route::get('/admin/incident-reports', [BarangayAdminController::class, 'incidentReports'])->name('admin.incident-reports');
    Route::post('/admin/generate-report', [BarangayAdminController::class, 'generateReport'])->name('admin.generate-report');
    Route::get('/admin/security', [BarangayAdminController::class, 'securityManagement'])->name('admin.security');
    Route::get('/admin/security-audit', [BarangayAdminController::class, 'securityAudit'])->name('admin.security-audit');
    Route::get('/admin/access-codes', [BarangayAdminController::class, 'manageAccessCodes'])->name('admin.access-codes');
    Route::post('/admin/access-codes', [BarangayAdminController::class, 'createAccessCode'])->name('admin.create-access-code');
    Route::patch('/admin/access-codes/{accessCode}/revoke', [BarangayAdminController::class, 'revokeAccessCode'])->name('admin.revoke-access-code');
    Route::delete('/admin/access-codes/{accessCode}', [BarangayAdminController::class, 'deleteAccessCode'])->name('admin.delete-access-code');
});

require __DIR__.'/auth.php';
