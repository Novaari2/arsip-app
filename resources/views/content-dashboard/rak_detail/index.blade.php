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
@include('layouts.overview', ['text' => 'Nomor Rak', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('rak_detail.create') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-airplus"></i>Tambah</a>
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-striped table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor</th>
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
        ajax: "{{ route('rak_detail.index') }}",
        columns:[
            {
                data: "nama",
                name: "nama"
            },
            {
                data: "nomor",
                name: "nomor"
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
        ]
    });

    $(document).on('click','.delete-rak_detail', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            Swal.fire({
                title: 'Apakah anda yakin',
                text: `Akan Menghapus data dari ${name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#ff0000',
                confirmButtonText: 'Iya, lanjutkan!',
                cancelButtonColor: 'Batal'
             }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('rak_detail.destroy') }}",
                        type: "DELETE",
                        data: {id:id,_token: $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                        if(data.success) {
                            Swal.fire(
                                'Berhasil Terhapus!',
                                'data berhasil terhapus.',
                                'success'
                            )
                            $('#table1').DataTable().ajax.reload();
                        }else {
                            Swal.fire(
                                'Terjadi Kesalahan!',
                                `dengan pesan kesalahan ${e.message}`,
                                'error'
                            )
                        }
                        },
                        error: function(e) {
                            Swal.fire(
                                'Terjadi Kesalahan',
                                `${e.responseText}`,
                                'error'
                            )
                        }
                    })
                }
            })
        })
</script>
@endsection
