<?php

namespace App\Services;

use App\Models\BarangayAdmin;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\User;

class UserRoleProfileSyncService
{
    public function sync(User $user): void
    {
        if ($user->role === User::ROLE_PATIENT && ! $user->patient) {
            Patient::create([
                'user_id' => $user->id,
            ]);

            return;
        }

        if ($user->role === User::ROLE_NURSE && ! $user->nurse) {
            Nurse::create([
                'user_id' => $user->id,
                'specialization' => 'General',
                'license_number' => $this->nextUniqueLicense('LN', $user->id),
            ]);

            return;
        }

        if ($user->role === User::ROLE_DOCTOR && ! $user->doctor) {
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => 'General',
                'license_number' => $this->nextUniqueLicense('MD', $user->id),
            ]);

            return;
        }

        if ($user->role === User::ROLE_BARANGAY_ADMIN && ! $user->barangayAdmin) {
            BarangayAdmin::create([
                'user_id' => $user->id,
                'barangay_name' => 'Default Barangay',
            ]);
        }
    }

    private function nextUniqueLicense(string $prefix, int $userId): string
    {
        do {
            $candidate = sprintf('%s%d%s', $prefix, $userId, now()->format('YmdHisv'));

            $exists = Nurse::where('license_number', $candidate)->exists()
                || Doctor::where('license_number', $candidate)->exists();
        } while ($exists);

        return $candidate;
    }
}
