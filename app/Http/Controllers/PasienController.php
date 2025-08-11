<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{

    public function index()
    {
        $pasiens = Pasien::withTrashed()
            ->with('provinsi', 'kabupaten', 'kecamatan')
            ->latest()
            ->get()
            ->map(function ($pasien) {
                // Ubah format data wilayah di sini
                if ($pasien->provinsi) {
                    $pasien->provinsi->nama = Str::title(strtolower($pasien->provinsi->nama));
                }
                if ($pasien->kabupaten) {
                    $pasien->kabupaten->nama = Str::title(strtolower($pasien->kabupaten->nama));
                }
                if ($pasien->kecamatan) {
                    $pasien->kecamatan->nama = Str::title(strtolower($pasien->kecamatan->nama));
                }
                return $pasien;
            });
        return view('pages.master.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $provinsis = Provinsi::orderBy('nama')->get()->map(function ($provinsi) {
            $provinsi->nama = Str::title(strtolower($provinsi->nama));
            return $provinsi;
        });
        $latestPasien = Pasien::withTrashed()->orderBy('id', 'desc')->first();
        $lastId = $latestPasien ? $latestPasien->id : 0;
        $noRekamMedis = date('Ym') . '-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        return view('pages.master.pasien.create', compact('provinsis', 'noRekamMedis'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'no_rekam_medis' => 'required|string|unique:pasiens,no_rekam_medis',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'no_telepon' => 'nullable|string',
        ]);
        // dd($validatedData);
        try {
            Pasien::create($validatedData);
        } catch (\Throwable $e) {
            Log::error('Error saat menyimpan pasien baru: ' . $e->getMessage());
            report($e);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan periksa log untuk detail.')
                ->withInput();
        }

        if ($request->input('action') == 'save_and_new') {
            return redirect()->route('pasien.create')
                ->with('success', 'Pasien berhasil ditambahkan. Silakan tambah data baru.');
        }

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien baru berhasil ditambahkan.');
    }
    public function getKabupaten(Request $request)
    {
        $kabupatens = Kabupaten::where('provinsi_id', $request->provinsi_id)
            ->orderBy('nama')
            ->get()
            ->map(function ($kabupaten) {
                $kabupaten->nama = Str::title(strtolower($kabupaten->nama));
                return $kabupaten;
            });
        return response()->json($kabupatens);
    }

    public function getKecamatan(Request $request)
    {
        $kecamatans = Kecamatan::where('kabupaten_id', $request->kabupaten_id)
            ->orderBy('nama')
            ->get()
            ->map(function ($kecamatan) {
                $kecamatan->nama = Str::title(strtolower($kecamatan->nama));
                return $kecamatan;
            });
        return response()->json($kecamatans);
    }


    public function edit(Pasien $pasien)
    {
        $provinsis = Provinsi::orderBy('nama')->get()->map(function ($prov) {
            $prov->nama = Str::title(strtolower($prov->nama));
            return $prov;
        });
        $kabupatens = Kabupaten::where('provinsi_id', $pasien->provinsi_id)->orderBy('nama')->get()->map(function ($kab) {
            $kab->nama = Str::title(strtolower($kab->nama));
            return $kab;
        });
        $kecamatans = Kecamatan::where('kabupaten_id', $pasien->kabupaten_id)->orderBy('nama')->get()->map(function ($kec) {
            $kec->nama = Str::title(strtolower($kec->nama));
            return $kec;
        });
        return view('pages.master.pasien.edit', compact('pasien', 'provinsis', 'kabupatens', 'kecamatans'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validatedData = $request->validate([
            'no_rekam_medis' => [
                'required',
                'string',
                Rule::unique('pasiens')->ignore($pasien->id),
            ],
            'nama_pasien' => 'required|string|max:255',
            'nik' => [
                'required',
                'string',
                Rule::unique('pasiens')->ignore($pasien->id),
            ],
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'no_telepon' => 'nullable|string',
        ]);

        try {
            $pasien->update($validatedData);
        } catch (\Throwable $e) {
            Log::error('Error saat menyimpan pasien baru: ' . $e->getMessage());
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.')
                ->withInput();
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        try {
            $pasien->delete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mengarsipkan pasien.');
        }

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diarsipkan.');
    }

    public function restore($id)
    {
        try {
            Pasien::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal memulihkan pasien.');
        }

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        try {
            Pasien::onlyTrashed()->findOrFail($id)->forceDelete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus pasien secara permanen.');
        }

        return redirect()->route('pasien.index', ['status' => 'trashed'])->with('success', 'Pasien berhasil dihapus permanen.');
    }
}
