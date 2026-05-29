<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPemohon extends Model
{
    use HasFactory;

    protected $table = 'profil_pemohon';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'keperluan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the user that owns this profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if profile is complete
     */
    public function isComplete(): bool
    {
        return !empty($this->nik) && 
               !empty($this->nama_lengkap) && 
               !empty($this->alamat);
    }

    /**
     * Get formatted tanggal lahir
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d F Y') : '-';
    }

    /**
     * Get jenis kelamin display
     */
    public function getJenisKelaminDisplayAttribute(): string
    {
        return match($this->jenis_kelamin) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }
}
