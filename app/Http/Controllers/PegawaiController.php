<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pegawais = Pegawai::withTrashed()->latest()->get();

        // Kirim data ke view
        return view('pages.master.pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unlinkedUsers = User::whereDoesntHave('pegawai')->get();
        return view('pages.master.pegawai.create', compact('unlinkedUsers'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('pegawais', 'user_id')
            ],
            // 'nama_lengkap' tidak perlu divalidasi karena diambil dari user
            'nik' => [
                'required',
                'string',
                Rule::unique('pegawais', 'nik')
            ],
            'alamat'     => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'jabatan'    => 'required|string|max:100',
        ], [
            'user_id.required' => 'Anda harus memilih akun user untuk ditautkan.',
            'user_id.unique'   => 'User ini sudah terdaftar sebagai pegawai.',
            'nik.required'     => 'NIK wajib diisi.',
            'nik.unique'       => 'NIK ini sudah terdaftar.',
        ]);

        try {
            // Cari user yang dipilih dari dropdown
            $user = User::find($request->user_id);

            // Buat data pegawai baru
            // Nama lengkap diambil langsung dari nama user yang dipilih
            Pegawai::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $user->name,
                'nik'          => $request->nik,
                'alamat'       => $request->alamat,
                'no_telepon'   => $request->no_telepon,
                'jabatan'      => $request->jabatan,
            ]);
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }

        return redirect()->route('pegawai.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pages.master.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nik' => [
                'required',
                'string',
                Rule::unique('pegawais', 'nik')->ignore($pegawai->id)
            ],
            'alamat'     => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'jabatan'    => 'required|string|max:100',
        ]);

        try {
            $pegawai->update([
                'nik'          => $request->nik,
                'alamat'       => $request->alamat,
                'no_telepon'   => $request->no_telepon,
                'jabatan'      => $request->jabatan,
            ]);
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        if ($pegawai->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai Berhasil Dihapus.');
    }

    /**
     * Restore the specified resource from soft delete.
     */
    public function restore(string $id)
    {
        $pegawai = Pegawai::withTrashed()->findOrFail($id);
        if ($pegawai->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengembalikan akun Anda sendiri.');
        }

        $pegawai->restore();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai Berhasil Dikembalikan.');
    }

    /**
     * Force delete the specified resource.
     */
    public function forceDelete(string $id)
    {
        $pegawai = Pegawai::withTrashed()->findOrFail($id);
        if ($pegawai->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri secara permanen.');
        }

        $pegawai->forceDelete();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai Berhasil Dihapus Permanen.');
    }
}
