<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'provinsis';

    // ID tidak auto-increment dan tipenya string
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama'];

    /**
     * Satu provinsi memiliki banyak kabupaten.
     */
    public function kabupatens(): HasMany
    {
        return $this->hasMany(Kabupaten::class);
    }
}
