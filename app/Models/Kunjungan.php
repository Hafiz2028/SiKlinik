<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kunjungan',
        'pasien_id',
        'dokter_id',
        'jenis_kunjungan_id',
        'tanggal_kunjungan',
        'keluhan_utama',
        'status_kunjungan',
        'total_tagihan',
    ];

    // Relasi ke master data
    public function pasien(): BelongsTo { return $this->belongsTo(Pasien::class); }
    public function dokter(): BelongsTo { return $this->belongsTo(User::class, 'dokter_id'); }
    public function jenisKunjungan(): BelongsTo { return $this->belongsTo(JenisKunjungan::class); }

    // Relasi ke detail transaksi (pivot)
    public function tindakan(): BelongsToMany
    {
        return $this->belongsToMany(Tindakan::class, 'kunjungan_tindakan')
            ->withPivot('jumlah', 'harga_saat_transaksi')
            ->withTimestamps();
    }

    public function obat(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'kunjungan_obat')
            ->withPivot('jumlah', 'dosis', 'harga_saat_transaksi')
            ->withTimestamps();
    }
}
