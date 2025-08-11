<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKunjungan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nama'];

    public function kunjungan(): HasMany { return $this->hasMany(Kunjungan::class); }
}
