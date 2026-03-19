<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HealthIncident extends Model
{
    private const SEVERITY_ORDER_SQL = "CASE health_incidents.severity WHEN 'critical' THEN 4 WHEN 'high' THEN 3 WHEN 'medium' THEN 2 ELSE 1 END DESC";

    protected $fillable = [
        'patient_id',
        'incident_type',
        'request_channel',
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

    public function scopeOrderBySeverityDesc(Builder $query): Builder
    {
        return $query->orderByRaw(self::SEVERITY_ORDER_SQL);
    }

    public function scopePrioritizeAdviceQueue(Builder $query): Builder
    {
        return $query
            ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM medical_advices WHERE medical_advices.health_incident_id = health_incidents.id) THEN 1 ELSE 0 END ASC")
            ->orderBySeverityDesc();
    }
}
