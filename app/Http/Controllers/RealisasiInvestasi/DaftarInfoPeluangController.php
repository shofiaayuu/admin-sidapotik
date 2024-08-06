<?php

namespace App\Http\Controllers\RealisasiInvestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class DaftarInfopeluangController extends Controller
{

    public function index()
    {
        return view('admin.data.sidapotik.realisasiPeluang.daftar_info_peluang');
    }

    public function getData()
    {
        $data = DB::table('data.daftar_info_peluang')->orderBy('tahun', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="btn-group">
                    <button class="btn btn-icon btn-warning btn-edit-data" data-id="' . $row->id . '"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-icon btn-danger btn-hapus-data" data-id="' . $row->id . '"><i class="fa fa-trash-o"></i></button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|string',
            'prospek_bisnis' => 'nullable|string',
            'nama' => 'nullable|string',
            'biaya_investasi' => 'nullable|string',
            'biaya_oprasional' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $id = $request->get('id');
        $data = [
            'tahun' => $validatedData['tahun'],
            'prospek_bisnis' => $validatedData['prospek_bisnis'],
            'nama' => $validatedData['nama'],
            'biaya_investasi' => $validatedData['biaya_investasi'],
            'biaya_oprasional' => $validatedData['biaya_oprasional'],
            'keterangan' => $validatedData['keterangan'],
        ];

        if ($id) {
            DB::table('data.daftar_info_peluang')->where('id', $id)->update($data);
        } else {
            DB::table('data.daftar_info_peluang')->insert($data);
        }

        return response()->json(['success' => 'Data saved successfully.']);
    }

    public function edit($id)
    {
        $data = DB::table('data.daftar_info_peluang')->where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function destroy($id)
    {
        DB::table('data.daftar_info_peluang')->where('id', $id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}


