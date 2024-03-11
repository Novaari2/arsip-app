<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class FormatKutipanController extends Controller
{
    public function index()
    {
        return view('content-dashboard.format-kutipan.index');
    }

    public function exportPdf($filename, $template){
        $content = view('content-dashboard.format-kutipan.' . $template)->render();
        $html2pdf = new Html2Pdf('L','A4','en');
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
    }

    public function kutipanPdf()
    {
        $filename = 'Format_kutipan' . date('Y-m-d') . '.pdf';
        $template = 'format';

        $this->exportPdf($filename, $template);
    }
}
