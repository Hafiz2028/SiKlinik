<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Provinsi;
use App\Models\Kunjungan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JenisKunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Kunjungan::with('pasien', 'jenisKunjungan', 'dokter');
        $user = Auth::user();
        if ($user->hasRole('dokter')) {
            $query->whereIn('status_kunjungan', ['Menunggu', 'Diperiksa']);
        } elseif ($user->hasRole('admin')) {
            $query->get();
        } elseif ($user->hasRole('petugas-pendaftaran')) {
            $query->whereIn('status_kunjungan', ['Menunggu', 'Selesai', 'Batal']);
        } elseif ($user->hasRole('kasir')) {
            $query->whereIn('status_kunjungan', ['Selesai','Menunggu Pembayaran']);
        }
        $kunjungans = $query->latest('tanggal_kunjungan')->get();
        return view('pages.transaksi.kunjungan.index', compact('kunjungans'));
    }

    public function create()
    {
        $jenisKunjungans = JenisKunjungan::whereNull('deleted_at')->orderBy('nama')->get();
        $pasiens = Pasien::whereNull('deleted_at')->orderBy('nama_pasien')->get(['id', 'no_rekam_medis', 'nama_pasien', 'tanggal_lahir']);
        $dokters = User::whereHas('roles', function ($query) {
            $query->where('slug', 'dokter');
        })->whereNull('deleted_at')->get();
        $provinsis = Provinsi::orderBy('nama')->get()->map(function ($provinsi) {
            $provinsi->nama = Str::title(strtolower($provinsi->nama));
            return $provinsi;
        });
        return view('pages.transaksi.kunjungan.create', compact('jenisKunjungans', 'pasiens', 'dokters', 'provinsis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tipe_pasien' => 'required|in:lama,baru',
            'jenis_kunjungan_id' => 'required|exists:jenis_kunjungans,id',
            'dokter_id' => 'required|exists:users,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_utama' => 'nullable|string',
        ]);

        if ($request->tipe_pasien === 'lama') {
            $request->validate(['pasien_id' => 'required|exists:pasiens,id']);
        } else { // tipe_pasien === 'baru'
            $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'nik' => 'required|string|unique:pasiens,nik',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat' => 'required|string',
                'provinsi_id' => 'required|exists:provinsis,id',
                'kabupaten_id' => 'required|exists:kabupatens,id',
                'kecamatan_id' => 'required|exists:kecamatans,id',
            ]);
        }

        // Menggunakan transaction untuk memastikan kedua operasi (create pasien & create kunjungan) berhasil
        DB::beginTransaction();
        try {
            $pasienId = $request->pasien_id;
            if ($request->tipe_pasien === 'baru') {
                // 1. Generate No Rekam Medis baru
                $latestPasien = Pasien::withTrashed()->orderBy('id', 'desc')->first();
                $lastId = $latestPasien ? $latestPasien->id : 0;
                $noRekamMedis = date('Ym') . '-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

                // 2. Buat Pasien Baru
                $pasienBaru = Pasien::create([
                    'no_rekam_medis' => $noRekamMedis,
                    'nama_pasien' => $request->nama_pasien,
                    'nik' => $request->nik,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'provinsi_id' => $request->provinsi_id,
                    'kabupaten_id' => $request->kabupaten_id,
                    'kecamatan_id' => $request->kecamatan_id,
                    'no_telepon' => $request->no_telepon,
                ]);
                $pasienId = $pasienBaru->id;
            }

            // --- MEMBUAT DATA KUNJUNGAN ---
            // 1. Generate Kode Kunjungan unik
            $kodeKunjungan = 'KUNJ-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            // 2. Buat Kunjungan
            Kunjungan::create([
                'kode_kunjungan' => $kodeKunjungan,
                'pasien_id' => $pasienId,
                'dokter_id' => $request->dokter_id,
                'jenis_kunjungan_id' => $request->jenis_kunjungan_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan_utama' => $request->keluhan_utama,
                'status_kunjungan' => 'Menunggu',
            ]);

            DB::commit();

            return redirect()->route('kunjungan.index')
                ->with('success', 'Pendaftaran kunjungan baru berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat pendaftaran kunjungan: ' . $e->getMessage());
            report($e);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load('pasien', 'dokter', 'jenisKunjungan', 'tindakan', 'obat');
        return view('pages.transaksi.kunjungan.show', compact('kunjungan'));
    }
}
