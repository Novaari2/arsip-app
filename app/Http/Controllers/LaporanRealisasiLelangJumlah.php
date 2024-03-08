<?php

namespace App\Http\Controllers;

use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRealisasiLelangJumlah extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = RisalahLelang::all();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->created_at;
            })
            ->addColumn('jumlah_lot', function($row){
                $data = RisalahLelang::where('status_lelang', 1)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $data = RisalahLelang::where('status_lelang', 3)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $data = RisalahLelang::where('status_lelang', 3)->groupBy('status_lelang')->count();
                return $data;
            })
            ->rawColumns(['nama','jumlah_lot','realisasi_pokok_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-jumlah-perjenis.index');
    }

    public function laporanRealisasiJumlahPerjenis()
    {
        $template = "template_laporan_jumlah_realisasi_lelang_perjenis.xlsx";
        $filename = 'Laporan_jumlah_realisasi_lelang_perjenis' . date('Y-m-d') . '.xlsx';
        // $data = ['Gudang A', 'Laku', 'Tap', 'Batal'];
        $this->exportExcelRealisasiJumlahPerjenis($filename, $template);
    }

    public function exportExcelRealisasiJumlahPerjenis($filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        // dd($spreadsheet);
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'Laporan Realisasi Lelang Per Jenis/Asal Barang');

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
