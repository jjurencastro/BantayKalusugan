<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'blood_type',
        'medical_history',
        'allergies',
        'emergency_contact',
        'emergency_contact_phone',
        'date_of_birth',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getAgeAttribute(): ?int
    {
        if (!$this->date_of_birth instanceof Carbon) {
            return null;
        }

        return $this->date_of_birth->age;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function healthAlerts(): HasMany
    {
        return $this->hasMany(HealthAlert::class);
    }

    public function healthIncidents(): HasMany
    {
        return $this->hasMany(HealthIncident::class);
    }

    public function healthUpdates(): HasMany
    {
        return $this->hasMany(PatientHealthUpdate::class);
    }
}
