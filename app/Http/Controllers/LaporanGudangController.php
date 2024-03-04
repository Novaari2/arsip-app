<?php

namespace App\Http\Controllers;

use App\Models\RakGudang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanGudangController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::all();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_gudang', function($row){
                $gudang = RakGudang::find($row->rak_gudang_id);
                return $gudang->nama_gudang;
            })
            ->addColumn('no_rak', function($row){
                return '1';
            })
            ->addColumn('jumlah_risalah', function($row){
                return '1';
            })
            ->rawColumns(['nama','no_rak','jumlah_risalah'])
            ->make(true);
        }
        return view('content-dashboard.laporan-gudang.index');
    }
}
