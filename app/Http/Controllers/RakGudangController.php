<?php

namespace App\Http\Controllers;

use App\Models\RakGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class RakGudangController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = RakGudang::query();

            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $data->where(function($query) use ($searchValue) {
                    $query->where('nama_gudang', 'LIKE', '%' . $searchValue . '%');
                });
            }

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama_gudang;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('rak_gudang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                $btn .= '<button class="delete-rak_gudang btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['nama','action'])
            ->make(true);
        }
        return view('content-dashboard.rak_gudang.index');
    }

    public function destroy(Request $request) {
        try{
            $data = RakGudang::find(Crypt::decryptString($request->id));
            $data->delete();
            return redirect()->route('rak_gudang.index')->with('status','Data Berhasil Dihapus');
        }catch(Throwable $th){
            return redirect()->route('rak_gudang.index')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function edit($id){
        $data = RakGudang::find(Crypt::decryptString($id));
        return view('content-dashboard.rak_gudang.edit', compact('data'));
    }

    public function update(Request $request, $id){
        try{
            $data = RakGudang::find(Crypt::decryptString($id));
            $data->update([
                'nama_gudang' => $request->nama
            ]);

            return redirect()->route('rak_gudang.index')->with('status','Data Berhasil Diubah');
        }catch(Throwable $th){
            return redirect()->route('rak_gudang.update')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function store(Request $request){
        try{
            $data = RakGudang::create([
                'nama_gudang' => $request->nama
            ]);

            return redirect()->route('rak_gudang.index')->with('status','Data Berhasil Ditambahkan');
        }catch(Throwable $th){
            return redirect()->route('rak_gudang.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function create(){
        return view('content-dashboard.rak_gudang.add');
    }
}
