<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class AktaNikah extends Model
{
    use SoftDeletes, Searchable;
    protected $table = 'akta_nikah';

    protected $fillable = [
        'nomor_akta', 'nomor_buku', 'tanggal_akad', 'lokasi_akad',
        'nama_suami', 'nik_suami', 'tempat_lahir_suami', 'tanggal_lahir_suami', 'alamat_suami',
        'nama_istri', 'nik_istri', 'tempat_lahir_istri', 'tanggal_lahir_istri', 'alamat_istri',
        'nama_wali', 'jenis_wali', 'penghulu', 'mas_kawin',
        'kategori', 'lokasi_fisik', 'file_path',
        'status_arsip', 'keterangan', 'petugas_input_id',
    ];

    protected $casts = [
        'tanggal_akad' => 'date',
        'tanggal_lahir_suami' => 'date',
        'tanggal_lahir_istri' => 'date',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_input_id');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nomor_akta' => $this->nomor_akta,
            'nama_suami' => $this->nama_suami,
            'nama_istri' => $this->nama_istri,
            'lokasi_fisik' => $this->lokasi_fisik,
            'tanggal_akad' => $this->tanggal_akad ? clone $this->tanggal_akad : null,
        ];
    }
}