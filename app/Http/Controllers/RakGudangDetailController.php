<?php

namespace App\Http\Controllers;

use App\Models\RakGudang;
use App\Models\RakGudangDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class RakGudangDetailController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = RakGudangDetail::query();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                $gudang = RakGudang::where('id', $row->rak_gudang_id)->first();
                return $gudang ? $gudang->nama_gudang : '';
            })
            ->addColumn('nomor', function($row){
                return $row->no_rak;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('rak_detail.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                $btn .= '<button class="delete-rak_detail btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['nama','nomor','action'])
            ->make(true);
        }
        return view('content-dashboard.rak_detail.index');
    }

    public function destroy(Request $request) {
        try{
            $data = RakGudangDetail::find(Crypt::decryptString($request->id));
            $data->delete();
            return redirect()->route('rak_detail.index')->with('status','Data Berhasil Dihapus');
        }catch(Throwable $th){
            return redirect()->route('rak_detail.index')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function edit($id){
        $data = RakGudangDetail::find(Crypt::decryptString($id));
        $gudang = RakGudang::all();
        return view('content-dashboard.rak_detail.edit', compact('data', 'gudang'));
    }

    public function update(Request $request, $id){
        try{
            $data = RakGudangDetail::find(Crypt::decryptString($id));
            $data->update([
                'rak_gudang_id' => $request->gudang ? $request->gudang : $data->rak_gudang_id,
                'no_rak' => $request->nomor
            ]);

            return redirect()->route('rak_detail.index')->with('status','Data Berhasil Diubah');
        }catch(Throwable $th){
            return redirect()->route('rak_detail.update')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function store(Request $request){

        try{
            $data = RakGudangDetail::create([
                'rak_gudang_id' => $request->gudang,
                'no_rak' => $request->nomor
            ]);

            return redirect()->route('rak_detail.index')->with('status','Data Berhasil Ditambahkan');
        }catch(Throwable $th){
            return redirect()->route('rak_detail.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function create(){
        $gudang = RakGudang::all();
        return view('content-dashboard.rak_detail.add', compact('gudang'));
    }
}
