<?php

namespace App\Http\Controllers\RealisasiInvestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TargetCapaianController extends Controller
{

    public function index()
    {
        return view('admin.data.sidapotik.realisasiPeluang.target_capaian');
    }

    public function getData()
    {
        $data = DB::table('data.target_capaian')->orderBy('tahun', 'asc');

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
            'target' => 'nullable|string',
            'capaian' => 'nullable|string',
        ]);

        $id = $request->get('id');
        $data = [
            'tahun' => $validatedData['tahun'],
            'target' => $validatedData['target'],
            'capaian' => $validatedData['capaian'],
        ];

        if ($id) {
            DB::table('data.target_capaian')->where('id', $id)->update($data);
        } else {
            DB::table('data.target_capaian')->insert($data);
        }

        return response()->json(['success' => 'Data saved successfully.']);
    }

    public function edit($id)
    {
        $data = DB::table('data.target_capaian')->where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function destroy($id)
    {
        DB::table('data.target_capaian')->where('id', $id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}


