<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $email = 'admin@admin.com';
        $now = now();

        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'barangay_admin',
                'email_verified_at' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        $adminId = DB::table('users')
            ->where('email', $email)
            ->value('id');

        if ($adminId) {
            DB::table('barangay_admins')->updateOrInsert(
                ['user_id' => $adminId],
                [
                    'barangay_name' => 'System Administrator',
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        // Intentionally left blank to avoid deleting user accounts during rollback.
    }
};
