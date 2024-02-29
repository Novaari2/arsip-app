<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisLelang;
use App\Models\KategoriPemohon;
use App\Models\PejabatLelang;
use App\Models\RakGudang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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

    private function jenisPenawaran(){
        $penawaran = [
            '0' => 'Internet Open Bidding',
            '1' => 'Internet Closed Bidding',
            '2' => 'Kehadiran tertulis',
            '3' => 'Kehadiran lisan',
            '4' => 'E-konvensional',
            '5' => 'Tromol pos',
        ];

        return $penawaran;
    }

    public function add()
    {
        $jenis_penawaran = $this->jenisPenawaran();
        $jenis_lelang = JenisLelang::all();
        $kategori_pemohon = KategoriPemohon::all();
        $pejabat_lelang = PejabatLelang::all();
        $gudang = RakGudang::all();
        return view('content-dashboard.risalah_lelang.add', compact('jenis_lelang', 'pejabat_lelang', 'kategori_pemohon', 'gudang', 'jenis_penawaran'));
    }

    public function create(Request $request)
    {
       try{
            DB::beginTransaction();

            $risalah = new RisalahLelang;
            $risalah->pejabat_lelang_id = $request->nama_pejabat_lelang;
            $risalah->kategori_pemohon_id = $request->kategori_pemohon;
            $risalah->jenis_lelang_id = $request->jenis_lelang;
            $risalah->rak_gudang_id = $request->nama_gudang;
            $risalah->no_register = $request->no_regis;
            $risalah->tgl_register = $request->tgl_regis;
            $risalah->no_tiket_permohonan = $request->no_tiket_pemohon;
            $risalah->nama_entitas_pemohon = $request->nama_entitas;
            $risalah->nama_pemohon = $request->nama_pemohon;
            $risalah->no_permohonan = $request->no_surat_pemohon;
            $risalah->tgl_permohonan = $request->tgl_surat_pemohon;
            $risalah->nama_debitur = $request->nama_debitur;
            $risalah->no_hpkb = $request->no_hpkb;
            $risalah->tgl_hpkb = $request->tgl_hpkb;
            $risalah->no_penetapan = $request->no_penetapan_jadwal;
            $risalah->tgl_penetapan = $request->tgl_penetapan_jadwal;
            $risalah->tempat_lelang = $request->tempat_lelang;
            $risalah->no_risalah = $request->no_risalah_lelang;
            $risalah->tgl_lelang = $request->tgl_lelang;
            $risalah->save();
            if($risalah){
                for($i = 0; $i < count($request->no_lot_barang); $i++){
                    $barang = new Barang;
                    $barang->risalah_lelang_id = $risalah->id;
                    $barang->no_lot_barang = $request->no_lot_barang[$i];
                    $barang->uraian_barang = $request->uraian_barang[$i];
                    $barang->uang_jaminan = $request->uang_jaminan[$i];
                    $barang->nilai_limit = $request->nilai_limit[$i];
                    $barang->nama_pembeli = $request->nama_pembeli[$i];
					$barang->alamat_pembeli = $request->alamat_pembeli[$i];
					$barang->no_ktp = $request->no_ktp[$i];
					$barang->pokok_lelang = $request->harga_lelang[$i];
					$barang->bea_penjual = $request->bea_penjual[$i];
					$barang->bea_pembeli = $request->bea_pembeli[$i];
                    $barang->save();
                }
            }

            DB::commit();

           return response()->json(['success' => 'Data Berhasil Disimpan']);
        }catch(Throwable $th){
            DB::rollBack();
           return $th->getMessage();
        }
    }
}
