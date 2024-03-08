<?php

namespace App\Http\Controllers;

use App\Models\PejabatLelang;
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
            $data = PejabatLelang::with('risalahLelang')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama;
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $data = RisalahLelang::with('barang')->where('pejabat_lelang_id', $row->id)->get();
                $pk_lelang = [];
                foreach ($data as $key => $value) {
                    foreach ($value->barang as $key => $item) {
                        array_push($pk_lelang, $item->pokok_lelang);
                    }
                }
                $nominal = array_sum($pk_lelang);
                return number_format($nominal, 0, ',', '.');
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $data = RisalahLelang::with('barang')->where('pejabat_lelang_id', $row->id)->get();
                $pnpb_lelang = [];
                foreach ($data as $key => $value) {
                    foreach ($value->barang as $key => $item) {
                        $jml = $item->bea_penjual + $item->bea_pembeli;
                        array_push($pnpb_lelang, $jml);
                    }
                }
                $nominal = array_sum($pnpb_lelang);
                return number_format($nominal, 0, ',', '.');
            })
            ->addColumn('produktivitas_lelang', function($row){
                return '100';
            })
            ->rawColumns(['nama','realisasi_pokok_lelang','realisasi_pnbp_lelang','produktivitas_lelang'])
            ->make(true);
        }
        return view('content-dashboard.laporan-lelang-pejabat.index');
    }

    public function laporanRealisasiPejabat()
    {
        $template = "template_laporan_per_pejabat_lelang_tahun.xlsx";
        $filename = 'Laporan_pejabat_lelang_tahun' . date('Y-m-d') . '.xlsx';
        $data = PejabatLelang::with('risalahLelang')->get();
        $this->exportExcelRealisasiPejabat($data, $filename, $template);
    }

    public function exportExcelRealisasiPejabat($data, $filename, $template){
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

        $number = 1;
        foreach ($data as $key => $value) {
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $value->nama)->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $data = RisalahLelang::with('barang')->where('pejabat_lelang_id', $value->id)->get();
                $pk_lelang = [];
                foreach ($data as $key => $item) {
                    foreach ($item->barang as $key => $barang) {
                        array_push($pk_lelang, $barang->pokok_lelang);
                    }
                }
                $nominal = array_sum($pk_lelang);
            $sheet->setCellValue('C' . $row, number_format($nominal, 0, ',', '.'))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');

            $data = RisalahLelang::with('barang')->where('pejabat_lelang_id', $value->id)->get();
                $pnpb_lelang = [];
                foreach ($data as $key => $item) {
                    foreach ($item->barang as $key => $pnbp) {
                        $jml = $pnbp->bea_penjual + $pnbp->bea_pembeli;
                        array_push($pnpb_lelang, $jml);
                    }
                }
                $nominal = array_sum($pnpb_lelang);

            $sheet->setCellValue('D' . $row, number_format($nominal, 0, ',', '.'))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, '100')->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

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
