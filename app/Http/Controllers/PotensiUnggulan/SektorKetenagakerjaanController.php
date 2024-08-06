<?php

namespace App\Http\Controllers\PotensiUnggulan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SektorKetenagakerjaanController extends Controller
{
    public function index()
    {
        return view('admin.data.sidapotik.potensi_unggulan.sektor_ketenagakerjaan');
    }

    public function getData()
    {
        $data = DB::table('data.sektor_ketenagakerjaan');

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
            'nama_lembaga' => 'required|string',
            'alamat' => 'nullable|string',
            'jenis_pelatihan' => 'nullable|string',
        ]);

        $id = $request->get('id');
        $data = [
            'nama_lembaga' => $validatedData['nama_lembaga'],
            'alamat' => $validatedData['alamat'],
            'jenis_pelatihan' => $validatedData['jenis_pelatihan'],
        ];

        if ($id) {
            DB::table('data.sektor_ketenagakerjaan')->where('id', $id)->update($data);
        } else {
            DB::table('data.sektor_ketenagakerjaan')->insert($data);
        }

        return response()->json(['success' => 'Data saved successfully.']);
    }

    public function edit($id)
    {
        $data = DB::table('data.sektor_ketenagakerjaan')->where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function destroy($id)
    {
        DB::table('data.sektor_ketenagakerjaan')->where('id', $id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
