<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAccessCode extends Model
{
    protected $fillable = [
        'code',
        'role',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        // Check if code is active
        if (!$this->is_active) {
            return false;
        }

        // Check if expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check if usage limit exceeded
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public static function validateCode(string $code, string $role): bool
    {
        $accessCode = self::where('code', $code)
            ->where('role', $role)
            ->first();

        return $accessCode && $accessCode->isValid();
    }

    public function recordUsage(): void
    {
        $this->increment('used_count');
    }
}
