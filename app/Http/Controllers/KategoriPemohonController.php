<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class KategoriPemohonController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = KategoriPemohon::query();

            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $data->where(function($query) use ($searchValue) {
                    $query->where('nama', 'LIKE', '%' . $searchValue . '%');
                });
            }

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('kategori_pemohon.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                $btn .= '<button class="delete-kategori btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['nama','action'])
            ->make(true);
        }
        return view('content-dashboard.kategori_pemohon.index');
    }

    public function destroy(Request $request) {
        try{
            $data = KategoriPemohon::find(Crypt::decryptString($request->id));
            $data->delete();
            return redirect()->route('kategori_pemohon.index')->with('status','Data Berhasil Dihapus');
        }catch(Throwable $th){
            return redirect()->route('kategori_pemohon.index')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function edit($id){
        $data = KategoriPemohon::find(Crypt::decryptString($id));
        return view('content-dashboard.kategori_pemohon.edit', compact('data'));
    }

    public function update(Request $request, $id){
        try{
            $data = KategoriPemohon::find(Crypt::decryptString($id));
            $data->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('kategori_pemohon.index')->with('status','Data Berhasil Diubah');
        }catch(Throwable $th){
            return redirect()->route('kategori_pemohon.update')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function store(Request $request){
        try{
            $data = KategoriPemohon::create([
                'nama' => $request->nama
            ]);

            return redirect()->route('kategori_pemohon.index')->with('status','Data Berhasil Ditambahkan');
        }catch(Throwable $th){
            return redirect()->route('kategori_pemohong.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function create(){
        return view('content-dashboard.kategori_pemohon.add');
    }
}
