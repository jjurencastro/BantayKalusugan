<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientHealthUpdate extends Model
{
    protected $table = 'patient_health_updates';

    protected $fillable = [
        'patient_id',
        'nurse_id',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'weight',
        'height',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(Nurse::class);
    }
}
