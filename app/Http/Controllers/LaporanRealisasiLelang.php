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
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = RisalahLelang::with('barang')->get();
            
            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $data = $data->filter(function($item) use ($searchValue) {
                    return date('Y', strtotime($item->tgl_register)) == $searchValue;
                });
            }
            
            $data = $data->groupBy(function($item){
                return Carbon::parse($item->tgl_register)->format('Y');
            });

            // return response()->json($data);

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tahun', function($row){
                foreach ($row as $value) {
                    return date('Y', strtotime($value->tgl_register));
                }
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $pokok_lelang = 0;
                foreach ($row as $value) {
                    $pokok_lelang += $value->barang->where('risalah_lelang_id', $value->id)->sum('pokok_lelang');
                }
                return number_format($pokok_lelang, 0, ',', '.');
                // return '';
            })
            ->addColumn('realisasi_pnbp_lelang', function($row){
                $bea_penjual = 0;
                $bea_pembeli = 0;
                foreach ($row as $value) {
                    $bea_penjual += $value->barang->where('risalah_lelang_id', $value->id)->sum('bea_penjual');
                    $bea_pembeli += $value->barang->where('risalah_lelang_id', $value->id)->sum('bea_pembeli');
                }
                return number_format($bea_penjual + $bea_pembeli, 0, ',', '.');
            })
            ->addColumn('produktivitas_lelang', function($row){
                foreach ($row as $value) {
                    $rlLaku = $value->where('status_lelang', 1)->whereYear('tgl_register', $value->tgl_register)->get();
                    $rlTap = $value->where('status_lelang', 2)->whereYear('tgl_register', $value->tgl_register)->get();
                }
                $pro_lelang = (count($rlLaku) / (count($rlLaku) + count($rlTap))) * 100;
                return sprintf('%0.2f', $pro_lelang).'%';
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
        $data = RisalahLelang::with('barang')->get()->groupBy(function($item){
            return Carbon::parse($item->tgl_register)->format('Y');
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
            $pokok_lelang = 0;
            $bea_pembeli = 0;
            $bea_penjual = 0;
            foreach ($value as $key => $item) {
                $pokok_lelang += $item->barang->where('risalah_lelang_id', $item->id)->sum('pokok_lelang');
                $bea_penjual += $item->barang->where('risalah_lelang_id', $item->id)->sum('bea_penjual');
                $bea_pembeli += $item->barang->where('risalah_lelang_id', $item->id)->sum('bea_pembeli');
                $th = date('Y', strtotime($item->tgl_register));
                $rlLaku = $item->where('status_lelang', 1)->whereYear('tgl_register', $item->tgl_register)->get();
                $rlTap = $item->where('status_lelang', 2)->whereYear('tgl_register', $item->tgl_register)->get();
            }
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $th)->getStyle('B' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('C' . $row, number_format($pokok_lelang, 0, ',', '.'))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, number_format($bea_penjual + $bea_pembeli, 0, ',', '.'))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');

            $pro_lelang = (count($rlLaku) / (count($rlLaku) + count($rlTap))) * 100;

            $sheet->setCellValue('E' . $row, sprintf('%0.2f', $pro_lelang).'%')->getStyle('E' . $row)->getAlignment()->setHorizontal('center');

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
