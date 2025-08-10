<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WilayahController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::with('provinsi')->orderBy('nama')->get();
        $kecamatans = Kecamatan::with('kabupaten.provinsi')->orderBy('nama')->get();
        $listProvinsi = $provinsis;
        return view('pages.master.wilayah.index', compact(
            'provinsis',
            'kabupatens',
            'kecamatans',
            'listProvinsi'
        ));
    }

    public function getKabupatensByProvinsi(Provinsi $provinsi)
    {
        return response()->json($provinsi->kabupatens()->orderBy('nama')->get());
    }
}
