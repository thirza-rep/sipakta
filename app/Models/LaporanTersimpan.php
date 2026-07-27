<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTersimpan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_laporan',
        'tipe_laporan',
        'bulan',
        'tahun',
        'file_path',
        'pengelola_id',
    ];

    /**
     * Get the pengelola data who generated this report.
     */
    public function pengelola()
    {
        return $this->belongsTo(User::class, 'pengelola_id');
    }
}
