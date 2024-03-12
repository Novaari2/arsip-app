<?php

namespace App\Http\Controllers;

use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Tag\Svg\Rect;

class FormatKutipanController extends Controller
{
    public function index()
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
