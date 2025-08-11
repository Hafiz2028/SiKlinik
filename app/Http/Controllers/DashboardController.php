<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Metrik Utama (KPI)
        $kunjunganHariIni = Kunjungan::whereDate('tanggal_kunjungan', today())->count();
        $totalPasien = Pasien::count();
        $pendapatanHariIni = Kunjungan::whereDate('tanggal_kunjungan', today())->where('status_kunjungan', 'Selesai')->sum('total_tagihan');
        $obatHampirHabis = Obat::where('stok', '<=', 10)->count(); // Asumsi batas stok kritis adalah 10

        // 2. Data untuk Grafik Tren Kunjungan Bulanan (30 hari terakhir)
        $kunjungan30Hari = Kunjungan::select(
            DB::raw('DATE(tanggal_kunjungan) as tanggal'),
            DB::raw('count(*) as jumlah')
        )
            ->where('tanggal_kunjungan', '>=', Carbon::now()->subDays(30))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Format data untuk chart
        $labelsKunjungan = $kunjungan30Hari->pluck('tanggal')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $dataKunjungan = $kunjungan30Hari->pluck('jumlah');

        // 3. Data untuk Grafik Tindakan Terbanyak
        $tindakanTerbanyak = DB::table('kunjungan_tindakan')
            ->join('tindakans', 'kunjungan_tindakan.tindakan_id', '=', 'tindakans.id')
            ->select('tindakans.nama_tindakan', DB::raw('count(kunjungan_tindakan.tindakan_id) as jumlah'))
            ->groupBy('tindakans.nama_tindakan')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        $labelsTindakan = $tindakanTerbanyak->pluck('nama_tindakan');
        $dataTindakan = $tindakanTerbanyak->pluck('jumlah');

        // 4. Data untuk Grafik Obat Paling Sering Diresepkan
        $obatTerlaris = DB::table('kunjungan_obat')
            ->join('obats', 'kunjungan_obat.obat_id', '=', 'obats.id')
            ->select('obats.nama_obat', DB::raw('sum(kunjungan_obat.jumlah) as jumlah'))
            ->groupBy('obats.nama_obat')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        $labelsObat = $obatTerlaris->pluck('nama_obat');
        $dataObat = $obatTerlaris->pluck('jumlah');

        // 5. Data untuk Tabel Kunjungan Terbaru
        $kunjunganTerbaru = Kunjungan::with('pasien')->latest()->limit(5)->get();

        return view('dashboard', compact(
            'kunjunganHariIni',
            'totalPasien',
            'pendapatanHariIni',
            'obatHampirHabis',
            'labelsKunjungan',
            'dataKunjungan',
            'labelsTindakan',
            'dataTindakan',
            'labelsObat',
            'dataObat',
            'kunjunganTerbaru'
        ));
    }
}
