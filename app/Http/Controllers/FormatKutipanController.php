<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisLelang;
use App\Models\PejabatLelang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Tag\Svg\Rect;
use Yajra\DataTables\Facades\DataTables;

class FormatKutipanController extends Controller
{

    public function index(Request $request){
        $risalah = Barang::with('risalahLelang');
        
        if ($request->ajax() && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $risalah->whereHas('risalahLelang', function ($query) use ($searchValue) {
                $query->where('no_risalah', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('nama_pembeli', 'LIKE', '%' . $searchValue . '%');
            });
        }

        $risalah = $risalah->get();

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
                    $btn = '<a href="' . route('format.add', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning btn-sm"><i class="mdi mdi-lead-pencil"></i>Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['risalah','lot','pembeli','pejabat','action'])
                ->make(true);
            }
        return view('content-dashboard.format-kutipan.index');
    }

    public function add(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        // dd($id);
        return view('content-dashboard.format-kutipan.add');
    }

    public function exportPdf($data, $filename, $template, $input){
        $pejabat = PejabatLelang::where('id', $data->risalahLelang->pejabat_lelang_id)->first();
        $jenis_lelang = JenisLelang::where('id', $data->risalahLelang->jenis_lelang_id)->first();
        $content = view('content-dashboard.format-kutipan.' . $template, compact('data', 'input', 'pejabat','jenis_lelang'))->render();
        $html2pdf = new Html2Pdf('P','A4','en');
        if (ob_get_contents()) ob_end_clean();
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
    }

    public function kutipanPdf(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $filename = 'Format_kutipan' . date('Y-m-d') . '.pdf';
        $template = 'kutipan';
        // $data = RisalahLelang::where('id',12)->with('pejabatLelang','jenisLelang')->first();
        $data = Barang::where('id', $id)->with('risalahLelang')->first();
        // return response()->json($data);
        $input = $request->all();
        
        // return response()->json($data);

        $this->exportPdf($data, $filename, $template, $input);
    }
}
