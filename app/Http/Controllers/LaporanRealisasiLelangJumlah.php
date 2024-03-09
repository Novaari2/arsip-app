<?php

namespace App\Http\Controllers;

use App\Models\JenisLelang;
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
            $data = RisalahLelang::with('barang','jenisLelang')->get();
            // return response()->json($data);

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->jenisLelang->nama;
            })
            ->addColumn('jumlah_lot', function($row){
                return $row->barang->count();
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $sum = $row->barang->sum('pokok_lelang');
                return number_format($sum, 0, ',', '.');
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $bea_penjual = $row->barang->sum('bea_penjual');
                $bea_pembeli = $row->barang->sum('bea_pembeli');
                $sum = $bea_penjual + $bea_pembeli;
                return number_format($sum, 0, ',', '.');
            })
            ->rawColumns(['nama','jumlah_lot','realisasi_pokok_lelang','realisasi_pnbp_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-jumlah-perjenis.index');
    }

    public function laporanRealisasiJumlahPerjenis()
    {
        $template = "template_laporan_jumlah_realisasi_lelang_perjenis.xlsx";
        $filename = 'Laporan_jumlah_realisasi_lelang_perjenis' . date('Y-m-d') . '.xlsx';
        $data = RisalahLelang::with('barang','jenisLelang')->get();
        $this->exportExcelRealisasiJumlahPerjenis($data, $filename, $template);
    }

    public function exportExcelRealisasiJumlahPerjenis($data, $filename, $template){
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

        $number = 1;
        foreach($data as $value){
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $value->jenisLelang->nama)->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, $value->barang->count())->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, $value->barang->sum('pokok_lelang'))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, $value->barang->sum('bea_penjual') + $value->barang->sum('bea_pembeli'))->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

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
