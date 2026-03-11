<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BarangayAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Keep seeded admin credentials consistent across reseeds.
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'barangay_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create BarangayAdmin record if it doesn't exist
        BarangayAdmin::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'barangay_name' => 'System Administrator',
            ]
        );

        $this->command->info('Admin user created: admin@admin.com / admin');
    }
}
