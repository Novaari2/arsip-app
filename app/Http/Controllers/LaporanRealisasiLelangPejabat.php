<?php

namespace App\Http\Controllers;

use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRealisasiLelangPejabat extends Controller
{
    // report 3
    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::all();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->created_at;
            })
            ->addColumn('realiasi_pokok_lelang', function($row){
                $data = RisalahLelang::where('status_lelang', 1)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('realiasi_pnpb_lelang', function($row){
                $data = RisalahLelang::where('status_lelang', 2)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('produktivitas_lelang', function($row){
                $data = RisalahLelang::where('status_lelang', 3)->groupBy('status_lelang')->count();
                return $data;
            })
            ->rawColumns(['nama','realiasi_pokok_lelang','realiasi_pnpb_lelang','produktivitas_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-lelang-pejabat.index');
    }

    public function laporanRealisasiPejabat()
    {
        $template = "template_laporan_per_pejabat_lelang_tahun.xlsx";
        $filename = 'Laporan_pejabat_lelang_tahun' . date('Y-m-d') . '.xlsx';
        // $data = ['Gudang A', 'Laku', 'Tap', 'Batal'];
        $this->exportExcelRealisasiPejabat($filename, $template);
    }

    public function exportExcelRealisasiPejabat($filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        // dd($spreadsheet);
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'Laporan Realisasi Per Pejabat Lelang Tahun');

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
        $data = ['Gudang A', 'Laku', 'Tap', 'Batal'];

        $number = 1;
        for ($i = 0; $i <= 4; $i++) {
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, 'Gudang A')->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, 'Laku')->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
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
