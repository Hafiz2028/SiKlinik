<?php

use App\Models\JenisKunjungan;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    { 
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kunjungan')->unique();
            $table->foreignIdFor(Pasien::class)->constrained()->onUpdate('cascade');
            $table->foreignIdFor(User::class, 'dokter_id')->nullable()->constrained('users')->onUpdate('cascade');
            $table->foreignIdFor(JenisKunjungan::class)->constrained()->onUpdate('cascade');
            $table->dateTime('tanggal_kunjungan');
            $table->text('keluhan_utama')->nullable();
            $table->text('diagnosis')->nullable();
            $table->enum('status_kunjungan', [
                'Menunggu',
                'Diperiksa',
                'Menunggu Pembayaran',
                'Selesai',
                'Batal'
            ])->default('Menunggu');
            $table->decimal('total_tagihan', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
