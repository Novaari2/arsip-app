<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemohon;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;

class LaporanRealisasiLelangPerbarang extends Controller
{
    public function index(){

        if(request()->ajax()){
            $data = KategoriPemohon::with('risalahLelang')->get();
            // return response()->json($data);

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->nama;
            })
            ->addColumn('laku', function($row){
                $laku = RisalahLelang::where('st_lelang', 1)->where('kategori_pemohon_id', $row->id)->get();
                return count($laku);
            })
            ->addColumn('tap', function($row){
                $tap = RisalahLelang::where('st_lelang', 2)->where('kategori_pemohon_id', $row->id)->get();
                return count($tap);
            })
            ->addColumn('batal', function($row){
                $batal = RisalahLelang::where('st_lelang', 4)->where('kategori_pemohon_id', $row->id)->get();
                return count($batal);
            })
            ->addColumn('realisasi_pokok_lelang', function($row){
                $data = RisalahLelang::with('barang')->where('kategori_pemohon_id', $row->id)->get();
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
                $data = RisalahLelang::with('barang')->where('kategori_pemohon_id', $row->id)->get();
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
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('laporan_gudang.view', Crypt::encryptString($row->id)) . '" class="btn btn-primary btn-sm ml-1"><i class="mdi mdi-ubuntu"></i>Lihat</a>';
                return $btn;
            })
            ->rawColumns(['nama','laku','tap','batal','realisasi_pokok_lelang','realisasi_pnbp_lelang','action'])
            ->make(true);
        }
        return view('content-dashboard.laporan-perjenis-barang.index');
    }

    public function laporanRealisasiPerJenis(){
        $template = "template_laporan_realisasi_per_jenis.xlsx";
        $filename = 'Laporan_realisasi_per_jenis' . date('Y-m-d') . '.xlsx';
        $data = KategoriPemohon::with('risalahLelang')->get();
        $this->exportExcelRealisasiPerJenis($data, $filename, $template);
    }

    public function exportExcelRealisasiPerJenis($data, $filename, $template){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('template/' . $template));
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul laporan
        $sheet->setCellValue('A1', 'Laporan Realisasi Per Jenis/Lelang');
        // $sheet->mergeCells('A1:G1'); // Menggabungkan sel A1 sampai G1

        // Menyusun header
        // $sheet->setCellValue('A', 'No');
        // $sheet->setCellValue('B', 'Nama');
        // $sheet->setCellValue('C', 'Jumlah Frekuensi Lelang');
        // $sheet->setCellValue('C', 'Laku');
        // $sheet->setCellValue('D', 'Tap');
        // $sheet->setCellValue('F', 'Realisasi Pokok Lelang');
        // $sheet->setCellValue('G', 'Realisasi PNBP Lelang');

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

        // $headerCells = ['A3', 'B3', 'C3', 'C4', 'D4', 'D3', 'E4', 'F3', 'G3'];
        // foreach ($headerCells as $cell) {
        //     $sheet->getStyle($cell)->applyFromArray($setStyle);
        // }

        // Menyusun data
        $number = 1;
        foreach ($data as $item) {
            $laku = RisalahLelang::where('st_lelang', 1)->where('kategori_pemohon_id', $item->id)->get();
            $tap = RisalahLelang::where('st_lelang', 2)->where('kategori_pemohon_id', $item->id)->get();
            $batal = RisalahLelang::where('st_lelang', 4)->where('kategori_pemohon_id', $item->id)->get();
            $data = RisalahLelang::with('barang')->where('kategori_pemohon_id', $item->id)->get();
            $row = 4 + $number;
            $sheet->setCellValue('A' . $row, $number)->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B' . $row, $item->nama);
            $sheet->setCellValue('C' . $row, count($laku))->getStyle('C' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D' . $row, count($tap))->getStyle('D' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E' . $row, count($batal))->getStyle('E' . $row)->getAlignment()->setHorizontal('center');
                $pk_lelang = [];
                foreach ($data as $key => $value) {
                    foreach ($value->barang as $key => $item) {
                        array_push($pk_lelang, $item->pokok_lelang);
                    }
                }
                $rl_pokok = array_sum($pk_lelang);
            $sheet->setCellValue('F' . $row, number_format($rl_pokok, 0, ',', '.'))->getStyle('F' . $row)->getAlignment()->setHorizontal('center');
            $pnpb_lelang = [];
            $pnpb_lelang = [];
            foreach ($data as $key => $value) {
                foreach ($value->barang as $key => $item) {
                    $jml = $item->bea_penjual + $item->bea_pembeli;
                    array_push($pnpb_lelang, $jml);
                }
            }
            $rl_pnbp = array_sum($pnpb_lelang);
            $sheet->setCellValue('G' . $row, number_format($rl_pnbp, 0, ',', '.'))->getStyle('G' . $row)->getAlignment()->setHorizontal('center');
            // Menggabungkan sel C, D, E pada setiap baris
            $sheet->mergeCells('C3' . $row . ':E3' . $row);

            $sheet->getStyle('A' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('B' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('C' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('D' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('E' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('F' . $row)->applyFromArray($setStyle);
            $sheet->getStyle('G' . $row)->applyFromArray($setStyle);

            $number++;
        }

        // Menyimpan file spreadsheet
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function view($id){
        $id = Crypt::decryptString($id);
        $data = RisalahLelang::where('kategori_pemohon_id', $id)->with('kategoriPemohon')->get();
        return view('content-dashboard.laporan-perjenis-barang.view', compact('data'));
    }
}
