<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PejabatLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spipu\Html2Pdf\Html2Pdf;
use Yajra\DataTables\Facades\DataTables;

class FormatKuitansiController extends Controller
{
    public function index()
    {
        $risalah = Barang::with('risalahLelang')->get();

        if(request()->ajax()){
            return DataTables::of($risalah)
                ->addIndexColumn()
                ->addColumn('risalah', function($row){
                    return $row->risalahLelang->no_risalah;
                })
                ->addColumn('lot', function($row){
                    return $row->no_lot_barang;
                })
                ->addColumn('pembeli', function($row){
                    return $row->nama_pembeli;
                })
                ->addColumn('pejabat', function($row){
                    $pejabat = PejabatLelang::where('id', $row->risalahLelang->pejabat_lelang_id)->first();
                    return $pejabat ? $pejabat->nama : null;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('kuitansi.add', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning btn-sm"><i class="mdi mdi-lead-pencil"></i>Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['risalah','lot','pembeli','pejabat','action'])
                ->make(true);
            }
        return view('content-dashboard.format-kuitansi.index');
    }

    public function add()
    {
        return view('content-dashboard.format-kuitansi.add');
    }

    public function exportPdf($data, $filename, $template, $input){
        // $pejabat = PejabatLelang::where('id', $data->risalahLelang->pejabat_lelang_id)->first();
        // $jenis_lelang = JenisLelang::where('id', $data->risalahLelang->jenis_lelang_id)->first();
        $image = public_path('assets/images/logo-kuitansi.svg');
        $content = view('content-dashboard.format-kuitansi.' . $template, compact('image'))->render();
        $html2pdf = new Html2Pdf('P','A4','en');
        if (ob_get_contents()) ob_end_clean();
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
    }

    public function kuitansiPdf(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $filename = 'Format_kuitansi' . date('Y-m-d') . '.pdf';
        $template = 'kuitansi';
        // $data = RisalahLelang::where('id',12)->with('pejabatLelang','jenisLelang')->first();
        $data = Barang::where('id', $id)->with('risalahLelang')->first();
        // return response()->json($data);
        $input = $request->all();
        
        // return response()->json($data);

        $this->exportPdf($data, $filename, $template, $input);
    }
}
