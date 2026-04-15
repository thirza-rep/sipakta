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

    /**
     * Role constants
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_PENGELOLA_DATA = 'pengelola_data';
    public const ROLE_KEPALA_KUA = 'kepala_kua';
    public const ROLE_PEMOHON = 'pemohon';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is Pengelola Data (formerly Admin Data)
     */
    public function isPengelolaData(): bool
    {
        return $this->role === self::ROLE_PENGELOLA_DATA;
    }

    /**
     * Check if user is Kepala KUA
     */
    public function isKepalaKUA(): bool
    {
        return $this->role === self::ROLE_KEPALA_KUA;
    }

    /**
     * Check if user is Pemohon
     */
    public function isPemohon(): bool
    {
        return $this->role === self::ROLE_PEMOHON;
    }

    /**
     * Check if user can manage users (Admin only)
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can manage arsip (Pengelola Data only)
     */
    public function canManageArsip(): bool
    {
        return $this->isPengelolaData();
    }

    /**
     * Check if user can view reports (Pengelola Data and Kepala KUA)
     */
    public function canViewReports(): bool
    {
        return $this->isPengelolaData() || $this->isKepalaKUA();
    }

    /**
     * Check if user can view riwayat (Kepala KUA only)
     */
    public function canViewRiwayat(): bool
    {
        return $this->isKepalaKUA();
    }

    /**
     * Get user's arsip entries
     */
    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }

    /**
     * Get user's akta nikah entries
     */
    public function aktaNikah()
    {
        return $this->hasMany(AktaNikah::class, 'petugas_input_id');
    }

    /**
     * Get user's search logs
     */
    public function logPencarian()
    {
        return $this->hasMany(LogPencarian::class);
    }

    /**
     * Get user's profile (for pemohon)
     */
    public function profilPemohon()
    {
        return $this->hasOne(ProfilPemohon::class);
    }

    /**
     * Check if pemohon has completed profile
     */
    public function hasCompletedProfile(): bool
    {
        if (!$this->isPemohon()) {
            return true;
        }
        return $this->profilPemohon !== null && $this->profilPemohon->nik !== null;
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_PENGELOLA_DATA => 'Pengelola Data',
            self::ROLE_KEPALA_KUA => 'Kepala KUA',
            self::ROLE_PEMOHON => 'Pemohon',
            default => ucfirst($this->role),
        };
    }
}
