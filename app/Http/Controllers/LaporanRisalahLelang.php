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
            $data = RisalahLelang::all()->groupBy(function($item) {
                return $item->created_at->format('Y');
            });
            // return response()->json($data);

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tahun', function($row){
                return Carbon::parse($row->first()->created_at)->format('Y');
            })
            ->addColumn('rl_laku', function($row){
               $laku = RisalahLelang::where('st_lelang', 1)->get();
               return count($laku);
            })
            ->addColumn('rl_tap', function($row){
                $tap = RisalahLelang::where('st_lelang', 2)->get();
                return count($tap);
            })
            ->addColumn('batal', function($row){
                $batal = RisalahLelang::where('st_lelang', 4)->get();
                return count($batal);
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
        $data = RisalahLelang::all()->groupBy(function($item) {
            return $item->created_at->format('Y');
        });
        // return response()->json($data);
        $this->exportExcelRisalahLelang($data, $filename, $template);
    }

    public function exportExcelRisalahLelang($data, $filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        // dd($spreadsheet);
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
            $laku = RisalahLelang::where('st_lelang', 1)->get();
            $tap = RisalahLelang::where('st_lelang', 2)->get();
            $batal = RisalahLelang::where('st_lelang', 4)->get();
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, Carbon::parse($value->first()->created_at)->format('Y'))->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, count($laku))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, count($tap))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, count($batal))->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

            $sheet->getStyle('A' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('B' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('C' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('D' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('E' . $row)->applyFromArray($setStyle);

            $number++;
        }

        // if(ob_get_contents()) ob_end_clean();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
