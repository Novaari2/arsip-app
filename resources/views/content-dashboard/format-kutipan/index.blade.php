@extends('layouts.app')

@section('content')
<style>
    .form-meta-information{
        width: 100%;
    }
    .sup-required {
        color:red;
    }
    .custom-error-size {
        font-size: 11px;
    }
    .nav-tabs .nav-item .nav-link.active {
    background-color: rgba(255, 0, 0, 0.663);
    color: #FFF;
}

.nav-tabs .nav-item .nav-link {
  color: rgba(255, 0, 0, 0.663);
}
</style>
@include('layouts.overview', ['text' => 'Format Kutipan', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ route('risalah_lelang.add') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-airplus"></i>Tambah</a> --}}
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-striped table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>Nomor Risalah Lelang</th>
                                <th>No Lot Barang</th>
                                <th>Nama Pembeli</th>
                                <th>Pejabat Lelang</th>
                                <th>Action</th>
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

    let table = $('.data-all').DataTable({
        processing: true,
        serverSide: true,
        searchable: true,
        ajax: "{{ route('format.index') }}",
        columns:[
            {
                data: "risalah",
                name: "risalah"
            },
            {
                data: "lot",
                name: "lot"
            },
            {
                data: "pembeli",
                name: "pembeli"
            },
            {
                data: "pejabat",
                name: "pejabat"
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
        ]
    });

</script>
@endSection