<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HealthIncident extends Model
{
    protected $fillable = [
        'patient_id',
        'incident_type',
        'description',
        'symptoms',
        'status',
        'severity',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalReport()
    {
        return $this->hasOne(MedicalReport::class);
    }

    public function medicalAdvice(): HasOne
    {
        return $this->hasOne(MedicalAdvice::class);
    }
}
