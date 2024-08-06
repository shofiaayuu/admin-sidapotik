<?php

namespace App\Http\Controllers\RealisasiInvestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RealisasiInvestasiController extends Controller
{
    public function index()
    {
        return view('admin.data.sidapotik.realisasiPeluang.realisasi_investasi');
    }
}
