@extends('layouts.app')

@section('content')
<style>
    .custom-error-size{
        font-size: 11px;
    }
    .sup-required{
        color:red;
    }

    .form-section{
        display: none;
    }

    .form-section.current{
        display: inline;
    }

    .parsley-errors-list{
        color: red;
    }
</style>
@include('layouts.overview', ['text' => 'Detail Risalah Lelang', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" class="form-sample">
                        <div class="form-group">
                            <label for="">No Risalah Lelang </label>
                            <input type="text" id="no_risalah_lelang" name="no_risalah_lelang" class="form-control" value="{{ $risalah->no_risalah ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tanggal Lelang </label>
                            <input type="text" id="tgl_risalah_lelang" name="tgl_risalah_lelang" class="form-control" value="{{ $risalah->tgl_lelang ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Register Lelang </label>
                            <input type="text" class="form-control" value="{{ $risalah->no_register ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tgl Register Lelang </label>
                            <input type="text" class="form-control" value="{{ $risalah->tgl_register ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Tiket Pemohon </label>
                            <input type="text" name="" class="form-control" id="" value="{{ $risalah->no_tiket_permohonan ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Entitas Pemohon</label>
                            <input type="text" name="" class="form-control" id="" value="{{ $risalah->nama_entitas_pemohon ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tgl Surat Pemohon</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->tgl_permohonan ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Pemohon</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->nama_pemohon ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Kategori Pemohon</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->kategoriPemohon->nama ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Surat Pemohon</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->no_permohonan ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Debitur</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->nama_debitur ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No HPKB</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->no_hpkb ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tgl HPKB</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->tgl_hpkb ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Penetapan Jadwal Lelang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->no_penetapan ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tgl Penetapan Jadwal Lelang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->tgl_penetapan ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tempat Lelang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->tempat_lelang ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Surat Tugas Lelang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->st_lelang ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Status Lelang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $status_lelang ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Pejabat Lelang </label>
                           <input type="text" class="form-control" name="" id="" value="{{ $risalah->pejabatLelang->nama ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Tanggal Surat Tugas </label>
                            <input type="text" id="tgl_surat_tugas" name="tgl_surat_tugas" class="form-control" value="{{ date('d M Y', strtotime($risalah->tgl_surat_tugas)) ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Penjual </label>
                            <input type="text" id="nama_penjual" name="nama_penjual" class="form-control" value="{{ $risalah->nama_penjual ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">No Surat Tugas Penjual </label>
                            <input type="text" id="no_surat_tugas_penjual" name="no_surat_tugas_penjual" class="form-control" value="{{ $risalah->no_surat_tugas_penjual ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Jenis Lelang </label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->jenisLelang->nama ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Jenis Penawaran </label>
                            <input type="text" class="form-control" name="" id="" value="{{ $jns_penawaran ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Gudang </label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->rakGudang->nama_gudang ?? '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="Rak Gudang">Rak Gudang</label>
                            <input type="text" class="form-control" name="" id="" value="{{ $risalah->rakGudangDetail->no_rak ?? '' }}" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
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
            paging: false,
            info: false,
            searching: false,
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