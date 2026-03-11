<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_health_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('nurse_id')->nullable();
            $table->foreign('nurse_id')->references('id')->on('nurses')->onDelete('set null');
            $table->string('blood_pressure')->nullable(); // e.g., "120/80"
            $table->integer('heart_rate')->nullable(); // BPM
            $table->decimal('temperature', 5, 2)->nullable(); // Celsius
            $table->decimal('weight', 6, 2)->nullable(); // kg
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->text('notes')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_health_updates');
    }
};
