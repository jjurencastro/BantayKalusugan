<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearUserData extends Command
{
    protected $signature = 'db:clear-user-data
                            {--force : Skip confirmation prompt}';

    protected $description = 'Delete all transactional and profile data while keeping user accounts.';

    public function handle(): int
    {
        if (!$this->option('force')) {
            $this->warn('This will permanently delete ALL patient, nurse, doctor, and activity data.');
            $this->warn('User accounts will be preserved.');

            if (!$this->confirm('Are you sure you want to proceed?')) {
                $this->info('Aborted.');
                return self::SUCCESS;
            }
        }

        $tables = [
            'medical_reports',
            'medical_advices',
            'patient_health_updates',
            'health_alerts',
            'health_incidents',
            'patients',
            'nurses',
            'doctors',
            'barangay_admins',
            'admin_access_codes',
            'jobs',
            'cache',
            'cache_locks',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->line("  Cleared: <comment>{$table}</comment>");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->newLine();
        $this->info('Done. All data cleared. User accounts preserved.');

        return self::SUCCESS;
    }
}
