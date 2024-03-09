@extends('layouts.app')

@section('content')
<style>
    .custom-error-size{
        font-size: 11px;
    }
    .sup-required{
        color:red;
    }
</style>
@include('layouts.overview',['text' => 'Laporan Realisasi Lelang Pertahun','icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('laporan_gudang.printExcelPertahun') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-file-excel"></i>Excel</a>
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-striped table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Realisasi Pokok Lelang</th>
                                <th>Realisasi PNBP Lelang</th>
                                <th>Produktivitas Lelang</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
              </div>
        </div>
    </div>
</div>
@endSection
@section('script')
<script>
     let table = $('.data-all').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('laporan_gudang.index-pertahun') }}",
        columns:[
            {
                data: "DT_RowIndex",
            },
            {
                data: "tahun",
            },
            {
                data: "realisasi_pokok_lelang"
            },
            {
                data: "realisasi_pnbp_lelang"
            },
            {
                data: "produktivitas_lelang"
            }
        ]
    });

</script>
@endSection
