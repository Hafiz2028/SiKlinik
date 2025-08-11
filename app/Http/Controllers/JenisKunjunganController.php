<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKunjungan;
use Illuminate\Validation\Rule;

class JenisKunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jkunjungans = JenisKunjungan::withTrashed()->latest()->get();
        return view('pages.master.jeniskunjungan.index', compact('jkunjungans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.master.jeniskunjungan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_kunjungans,nama',
        ], [
            'nama.required' => 'Nama Jenis Kunjungan wajib diisi.',
            'nama.unique'   => 'Nama Jenis Kunjungan ini sudah terdaftar.',
        ]);

        try {
            JenisKunjungan::create($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }
        if ($request->input('action') == 'save_and_new') {
            return redirect()->route('jkunjungan.create')
                ->with('success', 'Jenis Kunjungan berhasil ditambahkan. Silakan tambah data baru.');
        }
        return redirect()->route('jkunjungan.index')
            ->with('success', 'Jenis Kunjungan berhasil ditambahkan.');
    }

    public function edit(JenisKunjungan $jkunjungan)
    {
        return view('pages.master.jeniskunjungan.edit', compact('jkunjungan'));
    }

    public function update(Request $request, JenisKunjungan $jkunjungan)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_kunjungans')->ignore($jkunjungan->id),
            ],
        ], [
            'nama.required' => 'Nama Jenis Kunjungan wajib diisi.',
            'nama.unique'   => 'Nama Jenis Kunjungan ini sudah terdaftar.',
        ]);

        try {
            $jkunjungan->update($request->all());
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        }

        return redirect()->route('jkunjungan.index')
            ->with('success', 'Jenis Kunjungan berhasil diperbarui.');
    }

    public function destroy(JenisKunjungan $jkunjungan)
    {
        try {
            $jkunjungan->delete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mengarsipkan Jenis Kunjungan.');
        }

        return redirect()->route('jkunjungan.index')->with('success', 'Jenis Kunjungan berhasil diarsipkan.');
    }

    public function restore($id)
    {
        try {
            JenisKunjungan::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal memulihkan Jenis Kunjungan.');
        }

        return redirect()->route('jkunjungan.index')->with('success', 'Jenis Kunjungan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        try {
            JenisKunjungan::onlyTrashed()->findOrFail($id)->forceDelete();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus Jenis Kunjungan secara permanen.');
        }

        return redirect()->route('jkunjungan.index', ['status' => 'trashed'])->with('success', 'Jenis Kunjungan berhasil dihapus permanen.');
    }
}
