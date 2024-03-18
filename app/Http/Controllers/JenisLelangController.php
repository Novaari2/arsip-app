<?php

namespace App\Http\Controllers;

use App\Models\JenisLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class JenisLelangController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = JenisLelang::query();

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
                $btn = '<a href="' . route('jenis_lelang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                $btn .= '<button class="delete-lelang btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['nama','action'])
            ->make(true);
        }
        return view('content-dashboard.jenis_lelang.index');
    }

    public function destroy(Request $request) {
        try{
            $data = JenisLelang::find(Crypt::decryptString($request->id));
            $data->delete();
            return redirect()->route('jenis_lelang.index')->with('status','Data Berhasil Dihapus');
        }catch(Throwable $th){
            return redirect()->route('jenis_lelang.index')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function edit($id){
        $data = JenisLelang::find(Crypt::decryptString($id));
        return view('content-dashboard.jenis_lelang.edit', compact('data'));
    }

    public function update(Request $request, $id){
        try{
            $data = JenisLelang::find(Crypt::decryptString($id));
            $data->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('jenis_lelang.index')->with('status','Data Berhasil Diubah');
        }catch(Throwable $th){
            return redirect()->route('jenis_lelang.update')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function store(Request $request){
        try{
            $data = JenisLelang::create([
                'nama' => $request->nama
            ]);

            return redirect()->route('jenis_lelang.index')->with('status','Data Berhasil Ditambahkan');
        }catch(Throwable $th){
            return redirect()->route('jenis_lelang.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }
    }

    public function create(){
        return view('content-dashboard.jenis_lelang.add');
    }
}
