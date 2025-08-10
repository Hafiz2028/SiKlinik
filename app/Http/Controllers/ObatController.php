<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::withTrashed()->latest()->get();
        return view('pages.master.obat.index', compact('obats'));
    }
    public function create()
    {
        return view('pages.master.obat.create');
    }

    public function store(Request $request)
    {
        // Validasi input tetap sama
        $request->validate([
            'nama_obat' => ['required', 'string', 'max:255', Rule::unique('obats', 'nama_obat')],
            'satuan'    => 'required|string|max:50',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'nama_obat.unique'   => 'Nama obat ini sudah terdaftar.',
            'satuan.required'    => 'Satuan wajib diisi.',
            'stok.required'      => 'Stok wajib diisi.',
            'stok.integer'       => 'Stok harus berupa angka.',
            'harga.required'     => 'Harga wajib diisi.',
            'harga.integer'      => 'Harga harus berupa angka.',
        ]);

        try {
            // Buat data obat baru
            Obat::create($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }

        // Tentukan tujuan redirect berdasarkan tombol yang ditekan
        if ($request->input('action') == 'save_and_new') {
            // Jika menekan "Simpan & Tambah Lagi", kembali ke halaman create
            return redirect()->route('obat.create')
                ->with('success', 'Obat berhasil ditambahkan. Silakan tambah data baru.');
        }

        // Default: kembali ke halaman index
        return redirect()->route('obat.index')
            ->with('success', 'Obat baru berhasil ditambahkan.');
    }
    public function edit(Obat $obat)
    {
        return view('pages.master.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => ['required', 'string', 'max:255', Rule::unique('obats', 'nama_obat')->ignore($obat->id)],
            'satuan'    => 'required|string|max:50',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|integer|min:0',
        ]);

        try {
            $obat->update($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        }

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        try {
            $obat->delete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mengarsipkan obat.');
        }

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diarsipkan.');
    }

    public function restore($id)
    {
        try {
            Obat::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal memulihkan obat.');
        }

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        try {
            Obat::onlyTrashed()->findOrFail($id)->forceDelete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus obat secara permanen.');
        }

        return redirect()->route('obat.index', ['status' => 'trashed'])->with('success', 'Obat berhasil dihapus permanen.');
    }
}
