<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TindakanController extends Controller
{
    public function index(Request $request)
    {
        $tindakans = Tindakan::withTrashed()->latest()->get();
        return view('pages.master.tindakan.index', compact('tindakans'));
    }

    public function create()
    {
        return view('pages.master.tindakan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tindakan' => ['required', 'string', 'max:255', Rule::unique('tindakans', 'nama_tindakan')],
            'harga'     => 'required|integer|min:0',
            'deskripsi'    => 'string',
        ], [
            'nama_obat.required' => 'Nama Tindakan wajib diisi.',
            'nama_obat.unique'   => 'Nama Tindakan ini sudah terdaftar.',
            'harga.required'     => 'Harga wajib diisi.',
            'harga.integer'      => 'Harga harus berupa angka.',
        ]);

        try {
            Tindakan::create($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }

        return redirect()->route('tindakan.index')->with('success', 'Tindakan baru berhasil ditambahkan.');
    }

    public function edit(Tindakan $tindakan)
    {
        return view('pages.master.tindakan.edit', compact('tindakan'));
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $request->validate([
            'nama_tindakan' => ['required', 'string', 'max:255', Rule::unique('tindakans', 'nama_tindakan')->ignore($tindakan->id)],
            'harga'     => 'required|integer|min:0',
            'deskripsi'    => 'string',
        ]);

        try {
            $tindakan->update($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        }

        return redirect()->route('tindakan.index')->with('success', 'Data Tindakan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tindakan $tindakan)
    {
        try {
            $tindakan->delete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mengarsipkan tindakan.');
        }

        return redirect()->route('tindakan.index')->with('success', 'Tindakan berhasil diarsipkan.');
    }

    public function restore($id)
    {
        try {
            Tindakan::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal memulihkan tindakan.');
        }

        return redirect()->route('tindakan.index')->with('success', 'Tindakan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        try {
            Tindakan::onlyTrashed()->findOrFail($id)->forceDelete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus tindakan secara permanen.');
        }

        return redirect()->route('tindakan.index', ['status' => 'trashed'])->with('success', 'Tindakan berhasil dihapus permanen.');
    }
}
