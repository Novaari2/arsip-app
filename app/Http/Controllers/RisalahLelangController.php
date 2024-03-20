<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisLelang;
use App\Models\KategoriPemohon;
use App\Models\PejabatLelang;
use App\Models\RakGudang;
use App\Models\RakGudangDetail;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class RisalahLelangController extends Controller
{

    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = RisalahLelang::query();

            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $data->where(function($query) use ($searchValue) {
                    $query->where('no_risalah', 'LIKE', '%' . $searchValue . '%')
                          ->orWhere('nama_pemohon', 'LIKE', '%' . $searchValue . '%');
                });
            }

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('risalah', function($row){
                return $row->no_risalah;
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
                $btn = '<a href="' . route('risalah_lelang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning btn-sm"><i class="mdi mdi-lead-pencil"></i>Edit</a>';
                $btn .= '<button class="delete-lelang btn btn-danger btn-sm ml-1 disabled" data-id=' . Crypt::encryptString($row->id) . ' data-name=' . $row->title . '><i class="mdi mdi-delete"></i>Delete</button>';
                $btn .= '<a href="' . route('risalah_lelang.view', Crypt::encryptString($row->id)) . '" class="btn btn-primary btn-sm ml-1"><i class="mdi mdi-ubuntu"></i>Lihat</a>';
                return $btn;
            })
            ->rawColumns(['risalah','tanggal','pemohon','pejabat','action'])
            ->make(true);
        }
        return view('content-dashboard.risalah_lelang.index');
    }

    private function jenisPenawaran(){
        $penawaran = [
            '1' => 'Internet Open Bidding',
            '2' => 'Internet Closed Bidding',
            '3' => 'Kehadiran tertulis',
            '4' => 'Kehadiran lisan',
            '5' => 'E-konvensional',
            '6' => 'Tromol pos',
        ];

        return $penawaran;
    }

    private function statusLelang(){
        $status = [
            '1' => 'Laku',
            '2' => 'TAP',
            '3' => 'Ditahan',
            '4' => 'Batal',
            '5' => 'Batal Karena Pelunasan',
        ];

        return $status;
    }

    public function add()
    {
        $jenis_penawaran = $this->jenisPenawaran();
        $jenis_lelang = JenisLelang::all();
        $kategori_pemohon = KategoriPemohon::all();
        $pejabat_lelang = PejabatLelang::all();
        $gudang = RakGudang::with('rakGudangDetails')->get();
        return view('content-dashboard.risalah_lelang.add', compact('jenis_lelang', 'pejabat_lelang', 'kategori_pemohon', 'gudang', 'jenis_penawaran'));
    }

    public function getNomorRak(Request $request){
        $rak = RakGudangDetail::where('rak_gudang_id', $request->id)->get();

        return response()->json($rak);
    }

    public function create(Request $request)
    {
        // dd($request->all());
       try{
            DB::beginTransaction();

            $risalah = new RisalahLelang;
            $risalah->pejabat_lelang_id = $request->nama_pejabat_lelang;
            $risalah->kategori_pemohon_id = $request->kategori_pemohon;
            $risalah->jenis_lelang_id = $request->jenis_lelang;
            $risalah->rak_gudang_id = $request->nama_gudang;
            $risalah->rak_gudang_detail_id = $request->nomor_rak;
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
            $risalah->st_lelang = $request->st_lelang;
            $risalah->tgl_surat_tugas = $request->tgl_surat_tugas;
            $risalah->nama_penjual = $request->nama_penjual;
            $risalah->no_surat_tugas_penjual = $request->no_surat_tugas_penjual;
            $risalah->jenis_penawaran = $request->jenis_penawaran;
            $risalah->status_lelang = $request->status_lelang;
            $risalah->save();
            if($risalah){
                for($i = 0; $i < count($request->no_lot_barang); $i++){
                    $barang = new Barang;
                    $barang->risalah_lelang_id = $risalah->id;
                    $barang->no_lot_barang = $request->no_lot_barang[$i];
                    $barang->uraian_barang = $request->uraian_barang[$i];
                    $barang->uang_jaminan = preg_replace("/[^0-9]/", "",$request->uang_jaminan[$i]);
                    $barang->nilai_limit = preg_replace("/[^0-9]/", "",$request->nilai_limit[$i]);
                    $barang->nama_pembeli = $request->nama_pembeli[$i];
					$barang->alamat_pembeli = $request->alamat_pembeli[$i];
					$barang->no_ktp = $request->no_ktp[$i];
					$barang->pokok_lelang = preg_replace("/[^0-9]/", "",$request->harga_lelang[$i]);
					$barang->bea_penjual = preg_replace("/[^0-9]/", "", $request->bea_penjual[$i]);
					$barang->bea_pembeli = preg_replace("/[^0-9]/", "", $request->bea_pembeli[$i]);
                    $barang->save();
                }
                if($barang){
                    DB::commit();
                    return redirect()->route('risalah_lelang.index')->with('success', 'Data Berhasil Disimpan');
                }
            }
        }catch(Throwable $th){
            DB::rollBack();
           return $th->getMessage();
        }
    }

    public function detail($id){
        $id = Crypt::decryptString($id);
        // dd($id);
        $risalah = Barang::where('risalah_lelang_id', $id)->get();

        if(request()->ajax()){
            return DataTables::of($risalah)
                ->addIndexColumn()
                ->addColumn('no_lot_barang', function($row){
                    return $row->no_lot_barang;
                })
                ->addColumn('uraian_barang', function($row){
                    return $row->uraian_barang;
                })
                ->addColumn('uang_jaminan', function($row){
                    return $row->uang_jaminan;
                })
                ->addColumn('nilai_limit', function($row){
                    return $row->nilai_limit;
                })
                ->addColumn('nama_pembeli', function($row){
                    return $row->nama_pembeli;
                })
                ->addColumn('alamat_pembeli', function($row){
                    return $row->alamat_pembeli;
                })
                ->addColumn('no_ktp', function($row){
                    return $row->no_ktp;
                })
                ->addColumn('pokok_lelang', function($row){
                    return $row->pokok_lelang;
                })
                ->addColumn('bea_penjual', function($row){
                    return $row->bea_penjual;
                })
                ->addColumn('bea_pembeli', function($row){
                    return $row->bea_pembeli;
                })
                ->rawColumns(['no_lot_barang','uraian_barang','uang_jaminan','nilai_limit','nama_pembeli','alamat_pembeli','no_ktp','pokok_lelang','bea_penjual','bea_pembeli'])
                ->make(true);
            }

        return view('content-dashboard.risalah_lelang.detail');
    }

    public function destroy(Request $request) {
        $id = Crypt::decryptString($request->id);
        try{
            DB::beginTransaction();
            $dataRisalah = RisalahLelang::find($id);
            if($dataRisalah){
                $dataRisalah->delete();
                $dataBarang = Barang::where('risalah_lelang_id', $id)->delete();
                if($dataBarang){
                    DB::commit();
                    return response()->json(['success' => 'Data Berhasil Dihapus']);
                }
            }
        }catch(Throwable $th){
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function view($id){
        $id = Crypt::decryptString($id);
        $risalah = RisalahLelang::where('id', $id)->with('pejabatLelang','jenisLelang','kategoriPemohon','rakGudang','rakGudangDetail')->first();
        $jns_penawaran = isset($this->jenisPenawaran()[$risalah->jenis_penawaran]) ? $this->jenisPenawaran()[$risalah->jenis_penawaran] : '';
        $status_lelang = isset($this->statusLelang()[$risalah->status_lelang]) ? $this->statusLelang()[$risalah->status_lelang] : '';
        return view('content-dashboard.risalah_lelang.view', compact('risalah','jns_penawaran','status_lelang'));
    }

    public function edit($id){
        $id = Crypt::decryptString($id);
        $risalah = RisalahLelang::where('id', $id)->with('pejabatLelang','jenisLelang','kategoriPemohon','rakGudang','rakGudangDetail','barang')->first();
        $kategori_pemohon = KategoriPemohon::all();
        $pejabat_lelang = PejabatLelang::all();
        $jenis_lelang = JenisLelang::all();
        $jenis_penawaran = $this->jenisPenawaran();
        $gudang = RakGudang::all();
        $jns_penawaran = isset($this->jenisPenawaran()[$risalah->jenis_penawaran]) ? $this->jenisPenawaran()[$risalah->jenis_penawaran] : '';
        $status_lelang = isset($this->statusLelang()[$risalah->status_lelang]) ? $this->statusLelang()[$risalah->status_lelang] : '';
       return view('content-dashboard.risalah_lelang.edit', compact('risalah','kategori_pemohon','pejabat_lelang', 'jenis_lelang','jenis_penawaran','gudang','status_lelang','jns_penawaran'));
    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        try{
            DB::beginTransaction();
            $risalah = RisalahLelang::find($id);
            $risalah->pejabat_lelang_id = $request->nama_pejabat_lelang;
            $risalah->kategori_pemohon_id = $request->kategori_pemohon;
            $risalah->jenis_lelang_id = $request->jenis_lelang;
            $risalah->rak_gudang_id = $request->nama_gudang;
            $risalah->rak_gudang_detail_id = $request->nomor_rak;
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
            $risalah->st_lelang = $request->st_lelang;
            $risalah->tgl_surat_tugas = $request->tgl_surat_tugas;
            $risalah->nama_penjual = $request->nama_penjual;
            $risalah->no_surat_tugas_penjual = $request->no_surat_tugas_penjual;
            $risalah->jenis_penawaran = $request->jenis_penawaran;
            $risalah->status_lelang = $request->status_lelang;
            $risalah->save();
            if($risalah){
                for($i = 0; $i < count($request->no_lot_barang); $i++){
                    $oldBarang = Barang::where('risalah_lelang_id', $risalah->id)->where('no_lot_barang', $request->no_lot_barang[$i])->first();
                    $oldBarang->delete();
                    if($oldBarang){
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
                    if($barang){
                        DB::commit();
                        return redirect()->route('risalah_lelang.index')->with('success', 'Data Berhasil Diubah');
                    }
                }
            }
        }catch(Throwable $th){
            DB::rollBack();
            return redirect()->route('risalah_lelang.edit')->withErrors($th->getMessage() . ' on the line ' . $th->getLine())->withInput();
        }

    }
}
