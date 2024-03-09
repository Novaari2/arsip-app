<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RisalahLelang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRealisasiLelang extends Controller
{
    //report 2
    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::all()->groupBy(function($item){
                return $item->created_at->year;
            });

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tahun', function($row){
                return Carbon::parse($row->first()->created_at)->format('Y');
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
               $pk_lelang = Barang::select('YEAR(created_at) year', DB::raw('SUM(pokok_lelang) as pokok_lelang'))->where('created_at', '=', date('Y', strtotime($row->first()->created_at)));
               return number_format($pk_lelang, 0, ',', '.');
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $bea_jual = Barang::sum('bea_penjual');
                $bea_beli = Barang::sum('bea_pembeli');
               $pnbp_lelang = $bea_jual + $bea_beli;
               return number_format($pnbp_lelang, 0, ',', '.');
            })
            ->addColumn('produktivitas_lelang', function($row){
                $rlLaku = RisalahLelang::where('st_lelang', 1)->where('created_at', $row->first()->created_at)->get();
                $rlTap = RisalahLelang::where('st_lelang', 2)->where('created_at', $row->first()->created_at)->get();
                $pro_lelang = (count($rlLaku) / (count($rlLaku) + count($rlTap))) * 100;
                return $pro_lelang . '%';
            })
            ->rawColumns(['tahun','realisasi_pokok_lelang','realisasi_pnbp_lelang','produktivitas_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-lelang-pertahun.index');
    }

    public function laporanRealisasiPerTahun()
    {
        $template = "template_laporan_realisasi_lelang_pertahun.xlsx";
        $filename = 'Laporan_realisasi_lelang_pertahun' . date('Y-m-d') . '.xlsx';
        $data = RisalahLelang::all()->groupBy(function($item){
            return $item->created_at->year;
        });
        $this->exportExcelRealisasipertahun($data, $filename, $template);
    }

    public function exportExcelRealisasipertahun($data, $filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        // dd($spreadsheet);
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'Laporan Realisasi Lelang Pertahun');

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
            $pk_lelang = Barang::sum('pokok_lelang')->where('created_at', $value->first()->created_at);
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, Carbon::parse($value->first()->created_at)->format('Y'))->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, number_format($pk_lelang, 0, ',', '.'))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, 'Tap')->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, 'Batal')->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

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
