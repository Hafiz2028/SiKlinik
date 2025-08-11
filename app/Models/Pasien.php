<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_rekam_medis',
        'nama_pasien',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'no_telepon',
    ];

    // Relasi ke tabel wilayah
    public function provinsi(): BelongsTo { return $this->belongsTo(Provinsi::class); }
    public function kabupaten(): BelongsTo { return $this->belongsTo(Kabupaten::class); }
    public function kecamatan(): BelongsTo { return $this->belongsTo(Kecamatan::class); }

    // Relasi ke transaksi: satu pasien bisa memiliki banyak kunjungan
    public function kunjungan(): HasMany { return $this->hasMany(Kunjungan::class); }
}
