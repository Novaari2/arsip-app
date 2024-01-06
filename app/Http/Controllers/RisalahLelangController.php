<?php

namespace App\Http\Controllers;

use App\Models\JenisLelang;
use App\Models\KategoriPemohon;
use App\Models\PejabatLelang;
use App\Models\RakGudang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class RisalahLelangController extends Controller
{

    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::query();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('risalah', function($row){
                return $row->no_register;
            })
            ->addColumn('tanggal', function($row){
                return strtotime($row->tgl_register) ? date('d-m-Y', strtotime($row->tgl_register)) : '';
            })
            ->addColumn('pemohon', function($row){
                return $row->nama_pemohon;
            })
            ->addColumn('pejabat', function($row){
                $pejabat = PejabatLelang::where('id', $row->pejabat_lelang_id)->first();
                return $pejabat ? $pejabat->nama : '';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('jenis_lelang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning-material btn-sm"><i class="mdi mdi-lead-pencil"></i></a>';
                // $btn .= '<button class="delete-lelang btn btn-danger-material btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i></button>';
                return $btn;
            })
            ->rawColumns(['risalah','tanggal','pemohon','pejabat','action'])
            ->make(true);
        }
        return view('content-dashboard.risalah_lelang.index');
    }

    public function add()
    {
        $jenis_lelang = JenisLelang::all();
        $kategori_pemohon = KategoriPemohon::all();
        $pejabat_lelang = PejabatLelang::all();
        $gudang = RakGudang::all();
        return view('content-dashboard.risalah_lelang.add', compact('jenis_lelang', 'pejabat_lelang', 'kategori_pemohon', 'gudang'));
    }

    public function create(Request $request)
    {
       try{
            $data = RisalahLelang::create([
                'pejabat_lelang_id' => $request->nama_pejabat_lelang,
                'kategori_pemohon_id' => $request->kategori_pemohon,
                'jenis_lelang_id' => $request->jenis_lelang,
                'rak_gudang_id' => $request->nama_gudang,
                'no_register'   => $request->no_regis,
                'tgl_register'  =>  $request->tgl_regis,
                'no_tiket_permohonan' => $request->no_tiket_pemohon,
                'nama_entitas_pemohon' => $request->nama_entitas,
                'nama_pemohon'  => $request->nama_pemohon,
                'no_permohonan' => $request->no_surat_pemohon,
                'tgl_permohonan' => $request->tgl_surat_pemohon,
                'nama_debitur' => $request->nama_debitur,
                'no_hpkb' => $request->no_hpkb,
                'tgl_hpkb' => $request->tgl_hpkb,
                'no_penetapan' => $request->no_penetapan_jadwal,
                'tgl_penetapan' => $request->tgl_penetapan_jadwal,
                'tempat_lelang' => $request->tempat_lelang,
                'no_risalah' => $request->no_risalah_lelang,
                'tgl_lelang' => $request->tgl_lelang,
                'no_lot_barang' => $request->no_lot_barang,
                'st_lelang' => $request->st_lelang,
                'tgl_surat_tugas'   => $request->tgl_surat_tugas,
                'nama_penjual' => $request->nama_penjual,
                'st_penjual' => $request->no_surat_tugas_penjual,
                'jenis_penawaran' => $request->jenis_penawaran,
                'uraian_barang' => $request->uraian_barang,
                'uang_jaminan' => $request->uang_jaminan,
                'nilai_limit' => $request->nilai_limit,
                'nama_pembeli' => $request->nama_pembeli,
                'alamat_pembeli' => $request->alamat_pembeli,
                'no_ktp' => $request->no_ktp,
                'pokok_lelang' => $request->harga_lelang,
                'bea_penjual'   => $request->bea_penjual,
                'bea_pembeli'   => $request->bea_pembeli,
                'status_lelang' => $request->status_lelang
            ]);

            return redirect()->route('risalah_lelang.add')->with('status','Data Berhasil Ditambahkan');
       }catch(Throwable $th){
           return redirect()->route('risalah_lelang.create')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
       }
    }
}
