<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'kabupaten_id', 'nama'];

    /**
     * Satu kecamatan milik satu kabupaten.
     */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
