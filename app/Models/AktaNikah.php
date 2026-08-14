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
     * Check if the document has a digital file uploaded.
     */
    public function hasDocument(): bool
    {
        return !empty($this->file_path);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            'id'                  => $this->id,

            // Administrasi
            'nomor_akta'          => $this->nomor_akta,
            'nomor_buku'          => $this->nomor_buku,
            'tanggal_akad'        => $this->tanggal_akad
                                        ? $this->tanggal_akad->format('Y-m-d')
                                        : null,
            'lokasi_akad'         => $this->lokasi_akad,
            'kategori'            => $this->kategori,
            'lokasi_fisik'        => $this->lokasi_fisik,

            // Data suami
            'nama_suami'          => $this->nama_suami,
            'nik_suami'           => $this->nik_suami,
            'tempat_lahir_suami'  => $this->tempat_lahir_suami,
            'tanggal_lahir_suami' => $this->tanggal_lahir_suami
                                        ? $this->tanggal_lahir_suami->format('Y-m-d')
                                        : null,
            'alamat_suami'        => $this->alamat_suami,

            // Data istri
            'nama_istri'          => $this->nama_istri,
            'nik_istri'           => $this->nik_istri,
            'tempat_lahir_istri'  => $this->tempat_lahir_istri,
            'tanggal_lahir_istri' => $this->tanggal_lahir_istri
                                        ? $this->tanggal_lahir_istri->format('Y-m-d')
                                        : null,
            'alamat_istri'        => $this->alamat_istri,

            // Wali & penghulu
            'nama_wali'           => $this->nama_wali,
            'penghulu'            => $this->penghulu,

            // Lain-lain
            'mas_kawin'           => $this->mas_kawin,
            'keterangan'          => $this->keterangan,
        ];
    }
}