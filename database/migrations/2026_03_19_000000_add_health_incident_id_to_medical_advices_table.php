<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_advices', function (Blueprint $table) {
            $table->foreignId('health_incident_id')
                ->nullable()
                ->after('patient_id')
                ->constrained('health_incidents')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('medical_advices', function (Blueprint $table) {
            $table->dropConstrainedForeignId('health_incident_id');
        });
    }
};