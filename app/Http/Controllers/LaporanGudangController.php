<?php

namespace App\Http\Controllers;

use App\Exports\LaporanGudangExport;
use App\Models\RakGudang;
use App\Models\RakGudangDetail;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanGudangController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = RakGudang::with('risalahLelang');

            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $data->where('nama_gudang', 'LIKE', '%' . $searchValue . '%');
            }

            $data = $data->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_gudang', function($row){
                return $row->nama_gudang;
            })
            ->addColumn('no_rak', function($row){
                $nmr_rak = [];
                foreach ($row->risalahLelang as $key => $value) {
                    $rak = RakGudangDetail::where('id', $value->rak_gudang_detail_id)->get();
                    foreach ($rak as $key => $item) {
                        array_push($nmr_rak, 'No. Rak : ' . $item->no_rak . ' -> No. Risalah : ' . $value->no_risalah);
                    }
                }
                return implode('<br> ', $nmr_rak);
            })
            ->addColumn('jumlah_risalah', function($row){
                return count($row->risalahLelang);
            })
            ->rawColumns(['nama','no_rak','jumlah_risalah'])
            ->make(true);
        }
        return view('content-dashboard.laporan-gudang.index');
    }

    public function laporanGudangToExcel(Request $request)
    {
        $template = "template_laporan_gudang.xlsx";
        $filename = 'Laporan_gudang' . date('Y-m-d') . '.xlsx';
        $data = RakGudang::with('risalahLelang')->get();
        $this->exportExcelGudang($data, $filename, $template);
    }

    public function exportExcelGudang($data, $filename, $template){
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        // dd($spreadsheet);
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'Laporan Gudang');

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
        foreach ($data as $item) {
            $row = 3 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $item->nama_gudang);
            $nmr_rak = [];
            foreach ($item->risalahLelang as $key => $value) {
                $rak = RakGudangDetail::where('id', $value->rak_gudang_detail_id)->get();
                foreach ($rak as $key => $item) {
                    array_push($nmr_rak, 'No. Rak : ' . $item->no_rak . ' -> No. Risalah : ' . $value->no_risalah);
                }
            }
            $sheet->setCellValue('C' . $row, implode(', ', $nmr_rak));
            $sheet->setCellValue('D' . $row, count($item->risalahLelang));

            $sheet->getStyle('A' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('B' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('C' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('D' . $row)->applyFromArray($setStyle);

            $number++;
        }

        if(ob_get_contents()) ob_end_clean();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
