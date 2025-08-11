<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function show(Kunjungan $kunjungan)
    {
        // Eager load semua relasi yang dibutuhkan
        $kunjungan->load('pasien', 'dokter', 'tindakan', 'obat');
        return view('pages.transaksi.pembayaran.show', compact('kunjungan'));
    }

    /**
     * Memproses pembayaran dan menyelesaikan kunjungan.
     */
    public function update(Request $request, Kunjungan $kunjungan)
    {
        // Validasi sederhana, bisa dikembangkan dengan jumlah bayar, dll.
        $request->validate([
            'konfirmasi' => 'required'
        ]);

        try {
            $kunjungan->update([
                'status_kunjungan' => 'Selesai'
            ]);

            return redirect()->route('kunjungan.index')->with('success', 'Pembayaran berhasil dikonfirmasi dan kunjungan telah selesai.');
        } catch (\Throwable $e) {
            Log::error('Error saat konfirmasi pembayaran: ' . $e->getMessage());
            report($e);
            return redirect()->back()->with('error', 'Gagal memproses pembayaran.');
        }
    }
}
