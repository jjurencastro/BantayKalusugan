<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthAlert extends Model
{
    protected $fillable = [
        'patient_id',
        'alert_type',
        'message',
        'severity',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
