<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MedicalReport;
use App\Models\HealthIncident;
use App\Models\AdminAccessCode;
use App\Support\DateInput;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangayAdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();

        $roleDistribution = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        $roleDistribution = array_merge([
            'patient' => 0,
            'nurse' => 0,
            'doctor' => 0,
            'barangay_admin' => 0,
        ], $roleDistribution);

        $totalPatients = $roleDistribution['patient'];
        $totalNurses = $roleDistribution['nurse'];
        $totalDoctors = $roleDistribution['doctor'];
        $activePatients = $roleDistribution['patient'];

        $healthReportsCount = MedicalReport::count();
        $pendingreports = MedicalReport::where('status', 'pending')->count();

        $totalIncidents = HealthIncident::count();
        $incidentsCount = $totalIncidents;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPatients',
            'totalNurses',
            'totalDoctors',
            'activePatients',
            'healthReportsCount',
            'totalIncidents',
            'incidentsCount',
            'pendingreports',
            'roleDistribution'
        ));
    }

    public function manageUsers()
    {
        $users = User::with(['patient', 'nurse', 'doctor', 'barangayAdmin'])
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'phone'     => 'nullable|string',
            'address'   => 'nullable|string',
            'role'      => 'required|in:patient,nurse,doctor,barangay_admin',
            'is_active' => 'nullable|boolean',
        ]);

        $user->update(array_merge($validated, [
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function toggleUserStatus(User $user)
    {
        // Prevent admins from deactivating themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot change your own status.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $statusLabel = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.users')->with('success', "{$user->name} has been {$statusLabel}.");
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function healthReports()
    {
        $reports = MedicalReport::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.health-reports', compact('reports'));
    }

    public function incidentReports()
    {
        $totalIncidents    = HealthIncident::count();
        $criticalIncidents = HealthIncident::where('severity', 'critical')->count();
        $highSeverity      = HealthIncident::where('severity', 'high')->count();
        $resolvedIncidents = HealthIncident::where('status', 'resolved')->count();

        $incidentsByType = HealthIncident::selectRaw('incident_type, COUNT(*) as total')
            ->groupBy('incident_type')
            ->orderByDesc('total')
            ->get();

        $severityCounts = HealthIncident::selectRaw('severity, COUNT(*) as total')
            ->groupBy('severity')
            ->pluck('total', 'severity')
            ->toArray();

        $recentIncidents = HealthIncident::with('patient.user')
            ->orderBy('reported_at', 'desc')
            ->paginate(20);

        return view('admin.incident-reports', compact(
            'totalIncidents',
            'criticalIncidents',
            'highSeverity',
            'resolvedIncidents',
            'incidentsByType',
            'severityCounts',
            'recentIncidents'
        ));
    }

    public function generateReport(Request $request)
    {
        $request->merge([
            'start_date' => DateInput::normalize($request->input('start_date')),
            'end_date' => DateInput::normalize($request->input('end_date')),
        ]);

        $validated = $request->validate([
            'report_type' => 'required|in:health,incidents,users',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $startDate = $validated['start_date'] ?? now()->subMonths(1);
        $endDate = $validated['end_date'] ?? now();

        if ($validated['report_type'] === 'health') {
            $data = MedicalReport::whereBetween('created_at', [$startDate, $endDate])->get();
        } elseif ($validated['report_type'] === 'incidents') {
            $data = HealthIncident::whereBetween('reported_at', [$startDate, $endDate])->get();
        } else {
            $data = User::whereBetween('created_at', [$startDate, $endDate])->get();
        }

        return view('admin.report-view', compact('data', 'validated', 'startDate', 'endDate'));
    }

    public function securityManagement()
    {
        return view('admin.security');
    }

    public function securityAudit()
    {
        // Implement security audit logic
        return view('admin.security-audit');
    }

    public function manageAccessCodes()
    {
        $accessCodes = AdminAccessCode::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.access-codes', compact('accessCodes'));
    }

    public function createAccessCode(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:nurse,doctor',
            'usage_limit' => 'nullable|integer|min:1|max:100',
            'expires_days' => 'nullable|integer|min:1|max:365',
        ]);

        $code = strtoupper(Str::random(12));
        
        // Ensure code is unique
        while (AdminAccessCode::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(12));
        }

        $expiresAt = null;
        if (!empty($validated['expires_days'])) {
            $expiresAt = now()->addDays((int) $validated['expires_days']);
        }

        AdminAccessCode::create([
            'code' => $code,
            'role' => $validated['role'],
            'usage_limit' => $validated['usage_limit'] ?? null,
            'used_count' => 0,
            'expires_at' => $expiresAt,
            'is_active' => true,
        ]);

        return redirect()->route('admin.access-codes')->with('success', "Access code {$code} created successfully!");
    }

    public function revokeAccessCode(AdminAccessCode $accessCode)
    {
        $accessCode->update(['is_active' => false]);
        return redirect()->route('admin.access-codes')->with('success', 'Access code revoked successfully');
    }

    public function deleteAccessCode(AdminAccessCode $accessCode)
    {
        $accessCode->delete();
        return redirect()->route('admin.access-codes')->with('success', 'Access code deleted successfully');
    }
}
