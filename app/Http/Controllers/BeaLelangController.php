<?php

namespace App\Http\Controllers;

use App\Models\BeaLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BeaLelangController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $data = BeaLelang::query();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama;
            })
            ->addColumn('jenis', function($row){
                return $row->tipe;
            })
            ->addColumn('bea_penjual', function($row){
                return $row->bea_penjual;
            })
            ->addColumn('bea_pembeli', function($row){
                return $row->bea_pembeli;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('bea_lelang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                $btn .= '<button class="bea-lelang btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->nama . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['nama','jenis','bea_penjual','bea_pembeli','action'])
            ->make(true);
        }

        return view('content-dashboard.bea_lelang.index');
    }

    public function add()
    {
        return view('content-dashboard.bea_lelang.add');
    }

    public function create(Request $request){

        try{
            $data = BeaLelang::create([
                'nama' => $request->nama,
                'tipe' => $request->tipe,
                'bea_penjual' => $request->bea_penjual,
                'bea_pembeli' => $request->bea_pembeli
            ]);

            return redirect()->route('bea_lelang.index')->with('status','Data Berhasil Ditambahkan');
        }catch(Throwable $th){
            return redirect()->route('jenis_lelang.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function edit($id){
        $data = BeaLelang::find(Crypt::decryptString($id));
        return view('content-dashboard.bea_lelang.edit', compact('data'));
    }

    public function update(Request $request, $id){
        try{
            $data = BeaLelang::find(Crypt::decryptString($id));
            $data->update([
                'nama' => $request->nama,
                'tipe' => $request->tipe,
                'bea_penjual' => $request->bea_penjual,
                'bea_pembeli' => $request->bea_pembeli
            ]);

            return redirect()->route('bea_lelang.index')->with('status','Data Berhasil Diubah');
        }catch(Throwable $th){
            return redirect()->route('bea_lelang.update')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function destroy(Request $request) {
        try{
            $data = BeaLelang::find(Crypt::decryptString($request->id));
            $data->delete();
            return redirect()->route('bea_lelang.index')->with('status','Data Berhasil Dihapus');
        }catch(Throwable $th){
            return redirect()->route('bea_lelang.index')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }
}
