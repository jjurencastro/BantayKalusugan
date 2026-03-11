<?php

namespace Database\Seeders;

use App\Models\AdminAccessCode;
use Illuminate\Database\Seeder;

class AdminAccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test access codes for each role
        $codes = [
            ['code' => 'NURSE-TEST-001', 'role' => 'nurse', 'usage_limit' => 10],
            ['code' => 'NURSE-TEST-002', 'role' => 'nurse', 'usage_limit' => 10],
            ['code' => 'DOCTOR-TEST-001', 'role' => 'doctor', 'usage_limit' => 10],
            ['code' => 'DOCTOR-TEST-002', 'role' => 'doctor', 'usage_limit' => 10],
            ['code' => 'ADMIN-TEST-001', 'role' => 'barangay_admin', 'usage_limit' => 5],
            ['code' => 'ADMIN-TEST-002', 'role' => 'barangay_admin', 'usage_limit' => 5],
        ];

        foreach ($codes as $codeData) {
            AdminAccessCode::create([
                'code' => $codeData['code'],
                'role' => $codeData['role'],
                'usage_limit' => $codeData['usage_limit'],
                'used_count' => 0,
                'is_active' => true,
            ]);
        }
    }
}
