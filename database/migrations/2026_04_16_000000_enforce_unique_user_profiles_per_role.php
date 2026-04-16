<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $this->deduplicateProfiles('patients', [
                ['table' => 'health_alerts', 'column' => 'patient_id'],
                ['table' => 'health_incidents', 'column' => 'patient_id'],
                ['table' => 'patient_health_updates', 'column' => 'patient_id'],
                ['table' => 'medical_advices', 'column' => 'patient_id'],
                ['table' => 'medical_reports', 'column' => 'patient_id'],
            ]);

            $this->deduplicateProfiles('nurses', [
                ['table' => 'patient_health_updates', 'column' => 'nurse_id'],
            ]);

            $this->deduplicateProfiles('doctors', [
                ['table' => 'medical_advices', 'column' => 'doctor_id'],
                ['table' => 'medical_reports', 'column' => 'doctor_id'],
            ]);

            $this->deduplicateProfiles('barangay_admins', []);
        });

        Schema::table('patients', function (Blueprint $table): void {
            $table->unique('user_id', 'patients_user_id_unique');
        });

        Schema::table('nurses', function (Blueprint $table): void {
            $table->unique('user_id', 'nurses_user_id_unique');
        });

        Schema::table('doctors', function (Blueprint $table): void {
            $table->unique('user_id', 'doctors_user_id_unique');
        });

        Schema::table('barangay_admins', function (Blueprint $table): void {
            $table->unique('user_id', 'barangay_admins_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table): void {
            $table->dropUnique('patients_user_id_unique');
        });

        Schema::table('nurses', function (Blueprint $table): void {
            $table->dropUnique('nurses_user_id_unique');
        });

        Schema::table('doctors', function (Blueprint $table): void {
            $table->dropUnique('doctors_user_id_unique');
        });

        Schema::table('barangay_admins', function (Blueprint $table): void {
            $table->dropUnique('barangay_admins_user_id_unique');
        });
    }

    /**
     * Keep one profile per user and repoint dependent records before deleting duplicates.
     *
     * @param  array<int, array{table: string, column: string}>  $references
     */
    private function deduplicateProfiles(string $table, array $references): void
    {
        $duplicateUserIds = DB::table($table)
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id');

        foreach ($duplicateUserIds as $userId) {
            $ids = DB::table($table)
                ->where('user_id', $userId)
                ->orderBy('id')
                ->pluck('id')
                ->values();

            if ($ids->count() < 2) {
                continue;
            }

            $keepId = (int) $ids->first();
            $duplicateIds = $ids->slice(1)->map(fn ($id) => (int) $id)->all();

            foreach ($references as $reference) {
                DB::table($reference['table'])
                    ->whereIn($reference['column'], $duplicateIds)
                    ->update([$reference['column'] => $keepId]);
            }

            DB::table($table)->whereIn('id', $duplicateIds)->delete();
        }
    }
};
