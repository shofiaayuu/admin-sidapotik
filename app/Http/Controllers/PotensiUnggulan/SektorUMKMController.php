<?php

namespace App\Http\Controllers\PotensiUnggulan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SektorUMKMController extends Controller
{
    public function index()
    {
        return view('admin.data.sidapotik.potensi_unggulan.sektor_umkm');
    }

    public function getData()
    {
        $data = DB::table('data.sektor_umkm');

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
            'nama' => 'required|string',
            'alamat' => 'nullable|string',
            'nilai_aset' => 'nullable|string',
            'bidang_usaha' => 'nullable|string',
            'kapasitas_produksi' => 'nullable|string',
            'tenaga_kerja' => 'nullable|int',
            'pimpinan' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        $id = $request->get('id');
        $data = [
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'nilai_aset' => $validatedData['nama'],
            'bidang_usaha' => $validatedData['nilai_aset'],
            'kapasitas_produksi' => $validatedData['kapasitas_produksi'],
            'tenaga_kerja' => $validatedData['tenaga_kerja'],
            'pimpinan' => $validatedData['pimpinan'],
            'no_telp' => $validatedData['no_telp'],
            'email' => $validatedData['email'],
        ];

        if ($id) {
            DB::table('data.sektor_umkm')->where('id', $id)->update($data);
        } else {
            DB::table('data.sektor_umkm')->insert($data);
        }

        return response()->json(['success' => 'Data saved successfully.']);
    }

    public function edit($id)
    {
        $data = DB::table('data.sektor_umkm')->where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function destroy($id)
    {
        DB::table('data.sektor_umkm')->where('id', $id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
