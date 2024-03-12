<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PejabatLelang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Tag\Svg\Rect;
use Yajra\DataTables\Facades\DataTables;

class FormatKutipanController extends Controller
{

    public function index(){
        $risalah = Barang::with('risalahLelang')->get();
        // return response()->json($risalah);

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
                    $btn = '<a href="' . route('jenis_lelang.edit', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning btn-sm"><i class="mdi mdi-lead-pencil"></i>Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['risalah','lot','pembeli','pejabat','action'])
                ->make(true);
            }
        return view('content-dashboard.format-kutipan.index');
    }

    public function add()
    {
        return view('content-dashboard.format-kutipan.index');
    }

    public function exportPdf($data, $filename, $template){
        $content = view('content-dashboard.format-kutipan.' . $template, compact('data'))->render();
        $html2pdf = new Html2Pdf('P','A4','en');
        if (ob_get_contents()) ob_end_clean();
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
    }

    public function kutipanPdf(Request $request)
    {
        $filename = 'Format_kutipan' . date('Y-m-d') . '.pdf';
        $template = 'kutipan';
        $data = RisalahLelang::where('id',12)->with('pejabatLelang','jenisLelang')->first();
        // return response()->json($data);

        $this->exportPdf($data, $filename, $template);
    }
}
