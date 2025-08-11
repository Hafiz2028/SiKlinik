<?php

use App\Models\Kunjungan;
use App\Models\Tindakan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kunjungan::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Tindakan::class)->constrained()->onUpdate('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_saat_transaksi', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_tindakan');
    }
};
