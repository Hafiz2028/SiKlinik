<?php

use App\Models\Kunjungan;
use App\Models\Obat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kunjungan::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Obat::class)->constrained()->onUpdate('cascade');
            $table->integer('jumlah');
            $table->string('dosis');
            $table->decimal('harga_saat_transaksi', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_obat');
    }
};
