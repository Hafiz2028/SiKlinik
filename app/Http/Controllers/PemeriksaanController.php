<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Tindakan;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PemeriksaanController extends Controller
{
    public function edit(Kunjungan $kunjungan)
    {
        if ($kunjungan->status_kunjungan === 'Menunggu') {
            $kunjungan->update(['status_kunjungan' => 'Diperiksa']);
        }

        $kunjungan->load('pasien', 'tindakan', 'obat');
        $tindakans = Tindakan::whereNull('deleted_at')->orderBy('nama_tindakan')->get();
        $obats = Obat::whereNull('deleted_at')->orderBy('nama_obat')->get();
        $selectedTindakansData = $kunjungan->tindakan->map(function ($t) {
            return ['id' => $t->id, 'nama_tindakan' => $t->nama_tindakan];
        })->values();

        $selectedObatsData = $kunjungan->obat->map(function ($o) {
            return [
                'id' => $o->id,
                'nama_obat' => $o->nama_obat,
                'jumlah' => $o->pivot->jumlah,
                'dosis' => $o->pivot->dosis
            ];
        })->values();

        return view('pages.transaksi.pemeriksaan.edit', compact(
            'kunjungan',
            'tindakans',
            'obats',
            'selectedTindakansData',
            'selectedObatsData'
        ));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'diagnosis' => 'nullable|string',
            'tindakans' => 'nullable|array',
            'tindakans.*' => 'exists:tindakans,id', // Pastikan semua ID tindakan valid
            'obats' => 'nullable|array',
            'obats.*.id' => 'required|exists:obats,id', // Pastikan semua ID obat valid
            'obats.*.jumlah' => 'required|integer|min:1',
            'obats.*.dosis' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $totalTagihan = 0;

            // 1. Sinkronisasi dan Hitung Total Biaya Tindakan
            if ($request->has('tindakans')) {
                $tindakanData = [];
                $selectedTindakans = Tindakan::find($request->tindakans);
                foreach ($selectedTindakans as $tindakan) {
                    $tindakanData[$tindakan->id] = [
                        'jumlah' => 1, // Asumsi jumlah selalu 1
                        'harga_saat_transaksi' => $tindakan->harga
                    ];
                    $totalTagihan += $tindakan->harga;
                }
                $kunjungan->tindakan()->sync($tindakanData);
            } else {
                $kunjungan->tindakan()->detach(); // Hapus semua tindakan jika tidak ada yang dipilih
            }
            // 2. Sinkronisasi, Hitung Total Biaya Obat, dan Kurangi Stok
            if ($request->has('obats')) {
                $obatData = [];
                foreach ($request->obats as $resep) {
                    $obat = Obat::find($resep['id']);
                    if ($obat && $obat->stok >= $resep['jumlah']) {
                        $hargaTotalObat = $obat->harga * $resep['jumlah'];
                        $obatData[$obat->id] = [
                            'jumlah' => $resep['jumlah'],
                            'dosis' => $resep['dosis'],
                            'harga_saat_transaksi' => $obat->harga
                        ];
                        $totalTagihan += $hargaTotalObat;
                        // Kurangi stok obat
                        $obat->decrement('stok', $resep['jumlah']);
                    } else {
                        // Jika obat tidak ditemukan atau stok kurang, batalkan transaksi
                        throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi.");
                    }
                }
                $kunjungan->obat()->sync($obatData);
            } else {
                $kunjungan->obat()->detach(); // Hapus semua resep jika tidak ada yang dipilih
            }
            // 3. Update data Kunjungan
            $kunjungan->update([
                'diagnosis' => $request->diagnosis,
                'total_tagihan' => $totalTagihan,
                'status_kunjungan' => 'Menunggu Pembayaran', // Ubah status
            ]);
            DB::commit();
            return redirect()->route('kunjungan.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan pemeriksaan: ' . $e->getMessage());
            report($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
