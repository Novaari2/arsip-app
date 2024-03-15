<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
            $data = JenisLelang::with('risalahLelang','risalahLelang.barang')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama;
            })
            ->addColumn('jumlah_lot', function($row){
                $rsl = $row->risalahLelang;
                $sum = 0;
                foreach($rsl as $key => $value){
                    $sum += $value->barang->count();
                }
                return $sum;
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $rsl = $row->risalahLelang;
                $sum = 0;
                foreach($rsl as $key => $value){
                    $sum += $value->barang->where('risalah_lelang_id', $value->id)->sum('pokok_lelang');
                }
                return number_format($sum, 0, ',', '.');
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $rsl = $row->risalahLelang;
                $bea_penjual = 0;
                $bea_pembeli = 0;
                foreach($rsl as $key => $value){
                    $bea_penjual += $value->barang->where('risalah_lelang_id', $value->id)->sum('bea_penjual');
                    $bea_pembeli += $value->barang->where('risalah_lelang_id', $value->id)->sum('bea_pembeli');
                }
                return number_format($bea_penjual + $bea_pembeli, 0, ',', '.');
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
        $data = JenisLelang::with('risalahLelang','risalahLelang.barang')->get();
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
            $jml_lot = 0;
            $pokok_lelang = 0;
            $bea_penjual = 0;
            $bea_pembeli = 0;
            foreach($value->risalahLelang as $key => $item){
                $jml_lot += $item->barang->count();
                $pokok_lelang += $item->barang->where('risalah_lelang_id', $item->id)->sum('pokok_lelang');
                $bea_penjual += $item->barang->where('risalah_lelang_id', $item->id)->sum('bea_penjual');
                $bea_pembeli += $item->barang->where('risalah_lelang_id', $item->id)->sum('bea_pembeli');
            }
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $value->nama)->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, $jml_lot)->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, number_format($pokok_lelang, 0, ',', '.'))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, number_format($bea_penjual + $bea_pembeli, 0, ',', '.'))->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

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
