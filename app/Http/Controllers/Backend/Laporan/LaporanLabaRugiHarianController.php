<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanLabaRugiHarianController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.laporan.laporan_laba_rugi_harian.index');
    }
}
