@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('risalah_lelang.index') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-airplus"></i>Kembali</a>
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-bordered" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Lot Barang</th>
                                <th>Uraian Barang</th>
                                <th>Uang Jaminan</th>
                                <th>Nilai Limit</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat Pembeli</th>
                                <th>No Ktp</th>
                                <th>Pokok Lelang</th>
                                <th>Bea Penjual</th>
                                <th>Bea Pembeli</th>
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
@endsection

@section('script')
    <script>
        let id = "{{ Request::segment(4, 'default') }}";
        let table = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            searchable: true,
            scrollX: true,
            ajax: `{{ route('risalah_lelang.detail', Request::segment(4, 'default')) }}`,
            columns:[
                {
                    data: "DT_RowIndex",    
                },
                {
                    data: "no_lot_barang",
                },
                {
                    data: "uraian_barang",
                },
                {
                    data: "uang_jaminan",
                },
                {
                    data: "nilai_limit",
                },
                {
                    data: "nama_pembeli",
                },
                {
                    data: "alamat_pembeli",
                },
                {
                    data: "no_ktp",
                },
                {
                    data: "pokok_lelang",
                },
                {
                    data: "bea_penjual",
                },
                {
                    data: "bea_pembeli",
                }
            ]
        });
    </script>
@endsection