<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisLelang;
use App\Models\PejabatLelang;
use App\Models\RisalahLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spipu\Html2Pdf\Html2Pdf;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\EmailLog;

class FormatKuitansiController extends Controller
{
    public function index(Request $request)
    {
        $risalah = Barang::with('risalahLelang');

        if ($request->ajax() && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $risalah->whereHas('risalahLelang', function ($query) use ($searchValue) {
                $query->where('no_risalah', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('nama_pembeli', 'LIKE', '%' . $searchValue . '%');
            });
        }

        $risalah = $risalah->get();

        if(request()->ajax()){
            return DataTables::of($risalah)
                ->addIndexColumn()
                ->addColumn('risalah', function($row){
                    return $row->risalahLelang->no_risalah;
                })
                ->addColumn('lot', function($row){
                    return $row->no_lot_barang;
                })
                ->addColumn('pembeli', function($row){
                    return $row->nama_pembeli;
                })
                ->addColumn('pejabat', function($row){
                    $pejabat = PejabatLelang::where('id', $row->risalahLelang->pejabat_lelang_id)->first();
                    return $pejabat ? $pejabat->nama : null;
                })
                ->addColumn('has_email_log', function($row) {
                    return EmailLog::where('barang_id', $row->id)
                        ->where('document_type', 'kuitansi')
                        ->exists();
                })
                ->addColumn('last_email_date', function($row) {
                    $log = EmailLog::where('barang_id', $row->id)
                        ->where('document_type', 'kuitansi')
                        ->latest()
                        ->first();
                    return $log ? $log->created_at->format('Y-m-d H:i:s') : null;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('kuitansi.add', Crypt::encryptString($row->id)) . '" class="edit-categories btn btn-warning btn-sm"><i class="mdi mdi-lead-pencil"></i>Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['risalah','lot','pembeli','pejabat','action','has_email_log','last_email_date'])
                ->make(true);
            }
        return view('content-dashboard.format-kuitansi.index');
    }

    public function getEmailStatus($row)
    {
        // This method should not use localStorage as it's a server-side function
        // Instead, we'll check the database for email logs
        $emailLog = EmailLog::where('barang_id', $row->id)
            ->where('document_type', 'kuitansi')
            ->latest()
            ->first();

        if ($emailLog) {
            $timestamp = $emailLog->created_at->format('Y-m-d H:i:s');
            return '<span class="badge badge-success" title="Email terakhir dikirim: '.$timestamp.'">
                    <i class="mdi mdi-email-check"></i> Email Terkirim
                    </span>';
        } else {
            return '<span class="badge badge-secondary">
                    <i class="mdi mdi-email-outline"></i> Belum Dikirim
                    </span>';
        }
    }

    public function add()
    {
        return view('content-dashboard.format-kuitansi.add');
    }

    public function exportPdf($data, $filename, $template, $input){
        $pejabat = PejabatLelang::where('id', $data->risalahLelang->pejabat_lelang_id)->first();
        $jenis_lelang = JenisLelang::where('id', $data->risalahLelang->jenis_lelang_id)->first();
        $content = view('content-dashboard.format-kuitansi.' . $template, compact('data', 'input', 'pejabat','jenis_lelang'))->render();
        $html2pdf = new Html2Pdf('P','A4','en');
        if (ob_get_contents()) ob_end_clean();
        $html2pdf->writeHTML($content);
        $html2pdf->output($filename);
    }

    public function kuitansiPdf(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $filename = 'Format_kuitansi' . date('Y-m-d') . '.pdf';
        $template = 'kuitansi';
        // $data = RisalahLelang::where('id',12)->with('pejabatLelang','barang')->first();
        $data = Barang::where('id', $id)->with('risalahLelang')->first();
        // return response()->json($data);
        $input = $request->all();

        // return response()->json($data);

        $this->exportPdf($data, $filename, $template, $input);
    }

    public function sendEmail(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $email = $request->email;

            $data = Barang::where('id', $id)->with('risalahLelang')->first();
            $input = $request->all();
            $pejabat = PejabatLelang::where('id', $data->risalahLelang->pejabat_lelang_id)->first();
            $jenis_lelang = JenisLelang::where('id', $data->risalahLelang->jenis_lelang_id)->first();

            $details = [
                'title' => 'Kuitansi Lelang',
                'body' => 'This is a test email',
                'data' => $data,
                'jenis_lelang' => $jenis_lelang->nama,
                'kepala_kantor' => $request->kepala_kantor,
                'saksi_1' => $request->saksi_1,
            ];

            $filename = 'Format_kuitansi' . date('Y-m-d') . '.pdf';
            $html = view('content-dashboard.format-kuitansi.kuitansi', compact('data', 'input', 'pejabat','jenis_lelang', 'details'))->render();
            $html2pdf = new Html2Pdf('P','A4','en');
            $html2pdf->writeHTML($html);
            $pdfData = $html2pdf->output($filename, 'S');

            Mail::to($email)->send(new SendMail($details, $pdfData, 'Kuitansi Lelang', 'emails.kuitansi'));

            // Save email log
            EmailLog::create([
                'barang_id' => $id,
                'email_to' => $email,
                'document_type' => 'kuitansi',
                'status' => 'sent',
                'additional_info' => json_encode([
                    'kepala_kantor' => $request->kepala_kantor,
                    'saksi_1' => $request->saksi_1,
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ])
            ]);

            // Return JSON response with success status and message
            return response()->json([
                'status' => 'success',
                'message' => 'Email berhasil dikirim ke ' . $email,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'item_id' => $id  // Include the item ID in the response
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim email: ' . $th->getMessage()
            ]);
        }
    }
}