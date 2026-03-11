<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    public const ROLE_PATIENT = 'patient';
    public const ROLE_NURSE = 'nurse';
    public const ROLE_DOCTOR = 'doctor';
    public const ROLE_BARANGAY_ADMIN = 'barangay_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role checking methods
     */
    public function isPatient(): bool
    {
        return $this->role === self::ROLE_PATIENT;
    }

    public function isNurse(): bool
    {
        return $this->role === self::ROLE_NURSE;
    }

    public function isDoctor(): bool
    {
        return $this->role === self::ROLE_DOCTOR;
    }

    public function isBarangayAdmin(): bool
    {
        return $this->role === self::ROLE_BARANGAY_ADMIN;
    }

    /**
     * Relationships
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function barangayAdmin()
    {
        return $this->hasOne(BarangayAdmin::class);
    }
}
