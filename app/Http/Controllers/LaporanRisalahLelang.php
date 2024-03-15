<?php

namespace App\Http\Controllers;

use App\Models\RisalahLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRisalahLelang extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::select('tgl_register', 'status_lelang')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->tgl_register)->format('Y');
            });

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tahun', function($row){
               foreach ($row as $value) {
                   return date('Y', strtotime($value->tgl_register));
               }
            })
            ->addColumn('rl_laku', function($row){
                foreach ($row as $value) {
                    return count($value->where('status_lelang', 1)->whereYear('tgl_register', $value->tgl_register)->get());
                }
            })
            ->addColumn('rl_tap', function($row){
                foreach ($row as $value) {
                    return count($value->where('status_lelang', 2)->whereYear('tgl_register', $value->tgl_register)->get());
                }
            })
            ->addColumn('batal', function($row){
                foreach ($row as $value) {
                    return count($value->where('status_lelang', 4)->whereYear('tgl_register', $value->tgl_register)->get());
                }
            })
            ->rawColumns(['tahun','rl_laku','rl_tap','batal'])
            ->make(true);
        }
        return view('content-dashboard.laporan-risalah-lelang.index');
    }

    public function laporanRisalahLelang()
    {
        $template = "template_laporan_risalah_lelang.xlsx";
        $filename = 'Laporan_risalah_lelang' . date('Y-m-d') . '.xlsx';
        $data = RisalahLelang::select('tgl_register', 'status_lelang')
        ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->tgl_register)->format('Y');
        });
        
        $this->exportExcelRisalahLelang($data, $filename, $template);
    }

    public function exportExcelRisalahLelang($data, $filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'Laporan Risalah Lelang');

        $setStyle = [
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN
                ],

            ],
            'font' => [
                'size' => '11px'
            ]
        ];

        $number = 1;
        foreach ($data as $key => $value) {
            foreach($value as $v){
                $laku = $v->where('status_lelang', 1)->whereYear('tgl_register', $v->tgl_register)->get();
                $tap = $v->where('status_lelang', 2)->whereYear('tgl_register', $v->tgl_register)->get();
                $batal = $v->where('status_lelang', 4)->whereYear('tgl_register', $v->tgl_register)->get();
                $th = date('Y', strtotime($v->tgl_register));
            }
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $th)->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, count($laku))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, count($tap))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, count($batal))->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

            $sheet->getStyle('A' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('B' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('C' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('D' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('E' . $row)->applyFromArray($setStyle);

            $number++;
            // }
        }

        // if(ob_get_contents()) ob_end_clean();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
