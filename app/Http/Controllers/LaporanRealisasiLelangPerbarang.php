<?php

namespace App\Http\Controllers;

use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRealisasiLelangPerbarang extends Controller
{
    public function index(){

        if(request()->ajax()){
            $data = RisalahLelang::all();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->created_at;
            })
            ->addColumn('laku', function($row){
                $data = RisalahLelang::where('status_lelang', 1)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('tap', function($row){
                $data = RisalahLelang::where('status_lelang', 2)->groupBy('status_lelang')->count();
                return $data;
            })
            ->addColumn('batal', function($row){
                $data = RisalahLelang::where('status_lelang', 3)->groupBy('status_lelang')->count();
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
            ->rawColumns(['nama','laku','tap','batal','realisasi_pokok_lelang','realisasi_pnbp_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-perjenis-barang.index');
    }

    public function laporanRealisasiPerJenis(){
        $template = "template_laporan_realisasi_per_jenis.xlsx";
        $filename = 'Laporan_realisasi_per_jenis' . date('Y-m-d') . '.xlsx';
        $data = ['Gudang A', 'Laku', 'Tap', 'Batal', 'Realisasi Pokok','PNPB'];
        $this->exportExcelRealisasiPerJenis($data, $filename, $template);
    }

    public function exportExcelRealisasiPerJenis($data, $filename, $template){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul laporan
        $sheet->setCellValue('A1', 'Laporan Realisasi Per Jenis/Lelang');
        $sheet->mergeCells('A1:G1'); // Menggabungkan sel A1 sampai G1

        // Menyusun header
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama');
        $sheet->setCellValue('C3', 'Jumlah Frekuensi Lelang');
        $sheet->setCellValue('C4', 'Laku');
        $sheet->setCellValue('D4', 'Tap');
        $sheet->setCellValue('F3', 'Realisasi Pokok Lelang');
        $sheet->setCellValue('G3', 'Realisasi PNBP Lelang');

        // Menerapkan gaya pada header
        $setStyle = [
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN],
                'right' => ['borderStyle' => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'font' => ['size' => 11]
        ];

        $headerCells = ['A3', 'B3', 'C3', 'C4', 'D4', 'D3', 'E4', 'F3', 'G3'];
        foreach ($headerCells as $cell) {
            $sheet->getStyle($cell)->applyFromArray($setStyle);
        }

        // Menyusun data
        $number = 1;
        foreach ($data as $item) {
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, 'Gudang A');
            $sheet->setCellValue('C5' . $row, 'A1');
            $sheet->setCellValue('D5' . $row, '10');
            $sheet->setCellValue('E5' . $row, '10');
            $sheet->setCellValue('F5' . $row, '10');
            $sheet->setCellValue('G5' . $row, '10');
            // Menggabungkan sel C, D, E pada setiap baris
            $sheet->mergeCells('C3' . $row . ':E3' . $row);

            $sheet->getStyle('A' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('B' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('C5' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('D5' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('E5' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('F5' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('G5' . $row)->applyFromArray($setStyle);

            $number++;
        }

        // Menyimpan file spreadsheet
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }
}
