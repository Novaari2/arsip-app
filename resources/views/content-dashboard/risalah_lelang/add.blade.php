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
@include('layouts.overview', ['text' => 'Tambah Risalah Lelang', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('risalah_lelang.create') }}" method="POST">
                        @csrf
                        <div class="form-section">
                            <div class="form-group">
                                <label for="">No Risalah Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_risalah_lelang" name="no_risalah_lelang" class="form-control" value="{{ old('no_risalah_lelang') }}">
                                @if($errors->has('no_risalah_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_risalah_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Tgl Lelang <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_lelang" name="tgl_lelang" class="form-control" value="{{ old('tgl_lelang') }}">
                                @if($errors->has('tgl_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No Register Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_regis" name="no_regis" class="form-control" value="{{ old('no_regis') }}">
                                @if($errors->has('no_regis'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_regis') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Tgl Register Lelang <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_regis" name="tgl_regis" class="form-control" value="{{ old('tgl_regis') }}">
                                @if($errors->has('tgl_regis'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_regis') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No Tiket Pemohon <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_tiket_pemohon" name="no_tiket_pemohon" class="form-control" value="{{ old('no_tiket_pemohon') }}">
                                @if($errors->has('no_tiket_pemohon'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_tiket_pemohon') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Nama Entitas Pemohon <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_entitas" name="nama_entitas" class="form-control" value="{{ old('nama_entitas') }}">
                                @if($errors->has('nama_entitas'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_entitas') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Tgl Surat Pemohon <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_surat_pemohon" name="tgl_surat_pemohon" class="form-control" value="{{ old('tgl_surat_pemohon') }}">
                                @if($errors->has('tgl_surat_pemohon'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_surat_pemohon') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-section">

                            <div class="form-group">
                                <label for="">Nama Pemohon <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" value="{{ old('nama_pemohon') }}">
                                @if($errors->has('nama_pemohon'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_pemohon') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Kategori Pemohon</label>
                                <div>
                                    <select name="kategori_pemohon" id="kategori_pemohon" class="form-control">
                                        <option value="">Pilih Kategori Pemohon</option>
                                        @foreach ($kategori_pemohon as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">No Surat Pemohon <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_surat_pemohon" name="no_surat_pemohon" class="form-control" value="{{ old('no_surat_pemohon') }}">
                                @if($errors->has('no_surat_pemohon'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_surat_pemohon') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Nama Debitur <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_debitur" name="nama_debitur" class="form-control" value="{{ old('nama_debitur') }}">
                                @if($errors->has('nama_debitur'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_debitur') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No HPKB <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_hpkb" name="no_hpkb" class="form-control" value="{{ old('no_hpkb') }}">
                                @if($errors->has('no_hpkb'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_hpkb') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Tgl HPKB <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_hpkb" name="tgl_hpkb" class="form-control" value="{{ old('tgl_hpkb') }}">
                                @if($errors->has('tgl_hpkb'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_hpkb') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label for="">No Penetapan Jadwal Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_penetapan_jadwal" name="no_penetapan_jadwal" class="form-control" value="{{ old('no_penetapan_jadwal') }}">
                                @if($errors->has('no_penetapan_jadwal'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_penetapan_jadwal') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Tgl Penetapan Jadwal Lelang <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_penetapan_jadwal" name="tgl_penetapan_jadwal" class="form-control" value="{{ old('tgl_penetapan_jadwal') }}">
                                @if($errors->has('tgl_penetapan_jadwal'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_penetapan_jadwal') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Tempat Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="tempat_lelang" name="tempat_lelang" class="form-control" value="{{ old('tempat_lelang') }}">
                                @if($errors->has('tempat_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tempat_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No Surat Tugas Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="st_lelang" name="st_lelang" class="form-control" value="{{ old('status_lelang') }}">
                                @if($errors->has('status_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('status_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Status Lelang <sup class="sup-required">*</sup></label>
                                <select name="status_lelang" id="status_lelang" class="form-control">
                                    <option value="">Pilih Status Lelang</option>
                                    <option value="1">Laku</option>
                                    <option value="2">TAP</option>
                                    <option value="3">Ditahan</option>
                                    <option value="4">Batal</option>
                                    <option value="5">Batal Karena Pelunasan</option>
                                </select>
                                @if($errors->has('status_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('status_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Nama Pejabat Lelang <sup class="sup-required">*</sup></label>
                                <div>
                                    <select name="nama_pejabat_lelang" id="nama_pejabat_lelang" class="form-control">
                                        <option value="">Pilih Pejabat Lelang</option>
                                        @foreach($pejabat_lelang as $pejabat)
                                            <option value="{{ $pejabat->id }}" {{ old('nama_pejabat_lelang') == $pejabat->nama ? 'selected' : '' }}>{{ $pejabat->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($errors->has('nama_pejabat_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_pejabat_lelang') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Surat Tugas <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_surat_tugas" name="tgl_surat_tugas" class="form-control" value="{{ old('tgl_surat_tugas') }}">
                                @if($errors->has('tgl_surat_tugas'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_surat_tugas') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label for="">Nama Penjual <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_penjual" name="nama_penjual" class="form-control" value="{{ old('nama_penjual') }}">
                                @if($errors->has('nama_penjual'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_penjual') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No Surat Tugas Penjual <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_surat_tugas_penjual" name="no_surat_tugas_penjual" class="form-control" value="{{ old('no_surat_tugas_penjual') }}">
                                @if($errors->has('no_surat_tugas_penjual'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_surat_tugas_penjual') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Lelang <sup class="sup-required">*</sup></label>
                                <div>
                                    <select name="jenis_lelang" class="form-control" id="jenis_lelang">
                                        <option value="">Pilih Jenis Lelang</option>
                                        @foreach($jenis_lelang as $lelang)
                                            <option value="{{ $lelang->id }}" {{ old('jenis_lelang') == $lelang->id ? 'selected' : '' }}>{{ $lelang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Penawaran <sup class="sup-required">*</sup></label>
                                <div>
                                    <select name="jenis_penawaran" class="form-control" id="jenis_penawaran">
                                        <option value="">Pilih Jenis Penawaran</option>
                                        @foreach($jenis_penawaran as $key => $penawaran)
                                            <option value="{{ $key }}">{{ $penawaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Gudang <sup class="sup-required">*</sup></label>
                                <div>
                                    <select name="nama_gudang" id="nama_gudang" class="form-control">
                                        <option value="">Pilih Gudang</option>
                                        @foreach ($gudang as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_gudang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Rak Gudang">Rak Gudang</label>
                                <div>
                                    <select name="nomor_rak" id="nomor_rak" class="form-control">
                                        <option value="">Pilih Rak Gudang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <h5 class="font-weight-bold">Tambah Barang</h5>
                            <br>
                            <div class="form-container">
                            <div class="row-tambah-barang">
                                <div class="form-group row mt-4">
                                    <div class="col-md-6">
                                        <label for="">No Lot Barang <sup class="sup-required">*</sup></label>
                                        <input type="text" id="no_lot_barang_1" name="no_lot_barang[]" class="form-control input-no-lot" data-id="1">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Uraian Barang <sup class="sup-required">*</sup></label>
                                        <input type="text" id="uraian_barang_1" name="uraian_barang[]" class="form-control input-uraian" data-id="1">
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-md-6">
                                        <label for="">Uang Jaminan <sup class="sup-required">*</sup></label>
                                        <input type="text" id="uang_jaminan_1" name="uang_jaminan[]" class="form-control input-uang-jaminan" data-id="1">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Nilai Limit <sup class="sup-required">*</sup></label>
                                        <input type="text" id="nilai_limit_1" name="nilai_limit[]" class="form-control input-nilai-limit" data-id="1">

                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-md-6">
                                        <label for="">Nama Pembeli <sup class="sup-required">*</sup></label>
                                        <input type="text" id="nama_pembeli_1" name="nama_pembeli[]" class="form-control input-nama-pembeli" data-id="1">

                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Alamat Pembeli <sup class="sup-required">*</sup></label>
                                        <input type="text" id="alamat_pembeli_1" name="alamat_pembeli[]" class="form-control input-alamat-pembeli" data-id="1">

                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-md-6">
                                        <label for="">No. KTP <sup class="sup-required">*</sup></label>
                                        <input type="text" id="no_ktp_1" name="no_ktp[]" class="form-control input-no-ktp" data-id="1">

                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Harga Lelang <sup class="sup-required">*</sup></label>
                                        <input type="text" id="harga_lelang_1" name="harga_lelang[]" class="form-control input-harga-lelang" data-id="1">

                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-md-6">
                                        <label for="">Bea Lelang Penjual <sup class="sup-required">*</sup></label>
                                        <input type="text" id="bea_penjual_1" name="bea_penjual[]" class="form-control input-bea-penjual" data-id="1">

                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Bea Lelang Pembeli <sup class="sup-required">*</sup></label>
                                        <input type="text" id="bea_pembeli_1" name="bea_pembeli[]" class="form-control input-bea-pembeli" data-id="1">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger hapus-barang" data-id="1">Hapus</button>
                                <hr class="mt-5 border-1 border-dark">
                            </div>
                        </div>
                            <div class="mt-4 w-100">
                                <button type="button" id="tambah_barang" class="btn bg-green tambah_barang text-white w-100 shadow">
                                    Tambah Barang
                                </button>
                            </div>
                        </div>

                        <div class="form-navigation mt-3">
                            <button type="button" class="previous btn btn-blue-material mr-2">Kembali</button>
                            <button type="button" class="next btn bg-green mr-2">Selanjutnya</button>
                            <button type="submit" class="btn bg-green mr-2 text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        var $sections = $('.form-section');

        function navigateTo(index){
            $sections.removeClass('current').eq(index).addClass('current');

            $('.form-navigation .previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
        }

        function curIndex(){
            return $sections.index($sections.filter('.current'));
        }

        $('.form-navigation .previous').click(function(){
            navigateTo(curIndex() - 1);
        })

        $('.form-navigation .next').click(function(){
            $('.forms-sample').parsley().whenValidate({
                group: 'block-' + curIndex()
            }).done(function(){
                navigateTo(curIndex() + 1);
            })
        })

        $sections.each(function(index, section){
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
        })

        navigateTo(0);
    })
</script>
<script>
    $(document).ready(function(){
        let tambahBarang = [];

        function formatRupiah(angka) {
            let reverse = angka.toString().split('').reverse().join('');
            let ribuan = reverse.match(/\d{1,3}/g);
            let hasil = ribuan.join('.').split('').reverse().join('');
            return hasil;
        }


        $(document).on('input', '.input-no-lot', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }

            tambahBarang[index].no_lot_barang = $(this).val() || null;
        })


        $(document).on('input', '.input-uraian', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            tambahBarang[index].uraian_barang = $(this).val() || null;
        })


        $(document).on('input', '.input-uang-jaminan', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            let nilai = $(this).val();
            nilai = nilai.replace(/[^\d]/g,'');
            let uang_jaminan = formatRupiah(nilai);
            tambahBarang[index].uang_jaminan = $(this).val(uang_jaminan) || null;
        })


        $(document).on('input', '.input-nilai-limit', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            let nilai = $(this).val();
            nilai = nilai.replace(/[^\d]/g,'');
            let nilai_limit = formatRupiah(nilai);
            tambahBarang[index].nilai_limit = $(this).val(nilai_limit) || null;
        })


        $(document).on('input', '.input-nama-pembeli', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            tambahBarang[index].nama_pembeli = $(this).val() || null;
        })


        $(document).on('input', '.input-alamat-pembeli', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            tambahBarang[index].alamat_pembeli = $(this).val() || null;
        })


        $(document).on('input', '.input-no-ktp', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            tambahBarang[index].no_ktp = $(this).val() || null;
        })


        $(document).on('input', '.input-harga-lelang', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            let nilai = $(this).val();
            nilai = nilai.replace(/[^\d]/g,'');
            let harga_lelang = formatRupiah(nilai);
            tambahBarang[index].harga_lelang = $(this).val(harga_lelang) || null;
        })


        $(document).on('input', '.input-bea-penjual', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            let nilai = $(this).val();
            nilai = nilai.replace(/[^\d]/g,'');
            let bea_penjual = formatRupiah(nilai);
            tambahBarang[index].bea_penjual = $(this).val(bea_penjual) || null;
        })


        $(document).on('input', '.input-bea-pembeli', function(){
            const index = $(this).data('id') - 1;
            if (tambahBarang[index] === undefined) {
                tambahBarang[index] = {};
            }
            let nilai = $(this).val();
            nilai = nilai.replace(/[^\d]/g,'');
            let bea_pembeli = formatRupiah(nilai);
            tambahBarang[index].bea_pembeli = $(this).val(bea_pembeli) || null;
        })

        $('#tambah_barang').on('click', function() {
            let newId = tambahBarang.length + 1;
            tambahBarang.push({
                id: newId,
                no_lot_barang: null,
                uraian_barang: null,
                uang_jaminan: null,
                nilai_limit: null,
                nama_pembeli: null,
                alamat_pembeli: null,
                no_ktp: null,
                harga_lelang: null,
                bea_penjual: null,
                bea_pembeli: null
            });
            console.log(tambahBarang);
            let newRow = rowTambahBarang(tambahBarang[newId - 1]);
            $('.form-container').append(newRow);
        })

        $(document).on('click', '.hapus-barang', function(){
            let id = $(this).data('id');
            tambahBarang.splice(parseInt(id) - 1, 1);
            $(this).parent('.row-tambah-barang').remove();
        });

        function rowTambahBarang(value) {
            return `
                    <div class="row-tambah-barang">
                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <label for="">No Lot Barang <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_lot_barang_${value.id}" name="no_lot_barang[]" class="form-control input-no-lot" value="${value.no_lot_barang ? value.no_lot_barang : ''}" data-id="${value.id}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Uraian Barang <sup class="sup-required">*</sup></label>
                                <input type="text" id="uraian_barang_${value.id}" name="uraian_barang[]" class="form-control input-uraian" value="${value.uraian_barang ? value.uraian_barang : ''}" data-id="${value.id}">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <label for="">Uang Jaminan <sup class="sup-required">*</sup></label>
                                <input type="text" id="uang_jaminan_${value.id}" name="uang_jaminan[]" class="form-control input-uang-jaminan" value="${value.uang_jaminan ? value.uang_jaminan : ''}" data-id="${value.id}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Nilai Limit <sup class="sup-required">*</sup></label>
                                <input type="text" id="nilai_limit_${value.id}" name="nilai_limit[]" class="form-control input-nilai-limit" value="${value.nilai_limit ? value.nilai_limit : ''}" data-id="${value.id}">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <label for="">Nama Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_pembeli_${value.id}" name="nama_pembeli[]" class="form-control input-nama-pembeli" value="${value.nama_pembeli ? value.nama_pembeli : ''}" data-id="${value.id}"}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Alamat Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="alamat_pembeli_${value.id}" name="alamat_pembeli[]" class="form-control input-alamat-pembeli" value="${value.alamat_pembeli ? value.alamat_pembeli : ''}" data-id="${value.id}">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <label for="">No. KTP <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_ktp_${value.id}" name="no_ktp[]" class="form-control input-no-ktp" value="${value.no_ktp ? value.no_ktp : ''}" data-id="${value.id}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Harga Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="harga_lelang_${value.id}" name="harga_lelang[]" class="form-control input-harga-lelang" value="${value.harga_lelang ? value.harga_lelang : ''}" data-id="${value.id}">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <label for="">Bea Lelang Penjual <sup class="sup-required">*</sup></label>
                                <input type="text" id="bea_penjual_${value.id}" name="bea_penjual[]" class="form-control input-bea-penjual" value="${value.bea_penjual ? value.bea_penjual : ''}" data-id="${value.id}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Bea Lelang Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="bea_pembeli_${value.id}" name="bea_pembeli[]" class="form-control input-bea-pembeli" value="${value.bea_pembeli ? value.bea_pembeli : ''}" data-id="${value.id}">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger hapus-barang" data-id="${value.id}">Hapus</button>
                        <hr class="mt-5 border-1 border-dark">
                    </div>
                `;
            }
    });
</script>
<script>
    $('document').ready(function(){
        $('#nomor_rak').hide();

        $('#nama_gudang').on('change', function(){
            let token = $('meta[name="csrf-token"]').attr('content');
            let id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('risalah_lelang.getNomorRak') }}",
                data: {
                    id: id,
                    _token: token
                },
                success: function(data){
                    console.log(data.no_rak);
                    $('#nomor_rak').empty();
                    $.each(data, function(i, item){
                        $('#nomor_rak').append('<option value="' + item.no_rak + '">' + item.no_rak + '</option>');
                    })
                    $('#nomor_rak').show();
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            })
        })
    })
</script>
@endsection
