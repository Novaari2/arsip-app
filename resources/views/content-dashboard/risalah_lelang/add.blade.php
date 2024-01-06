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
                    <form class="forms-sample" action="{{ route('risalah_lelang.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-section">
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
                                <label for="">Tgl Surat Pemohon <sup class="sup-required">*</sup></label>
                                <input type="date" id="tgl_surat_pemohon" name="tgl_surat_pemohon" class="form-control" value="{{ old('tgl_surat_pemohon') }}">
                                @if($errors->has('tgl_surat_pemohon'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('tgl_surat_pemohon') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Nama Debitur <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_debitur" name="nama_debitur" class="form-control" value="{{ old('nama_debitur') }}">
                                @if($errors->has('nama_debitur'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_debitur') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-section">
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
                        </div>

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
                        </div>

                        <div class="form-section">
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
                                <input type="text" id="jenis_penawaran" name="jenis_penawaran" class="form-control" value="{{ old('jenis_penawaran') }}">
                                @if($errors->has('jenis_penawaran'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('jenis_penawaran') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No Lot Barang <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_lot_barang" name="no_lot_barang" class="form-control" value="{{ old('no_lot_barang') }}">
                                @if($errors->has('no_lot_barang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_lot_barang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Uraian Barang <sup class="sup-required">*</sup></label>
                                <input type="text" id="uraian_barang" name="uraian_barang" class="form-control" value="{{ old('uraian_barang') }}">
                                @if($errors->has('uraian_barang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('uraian_barang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Uang Jaminan <sup class="sup-required">*</sup></label>
                                <input type="text" id="uang_jaminan" name="uang_jaminan" class="form-control" value="{{ old('uang-uang_jaminan') }}">
                                @if($errors->has('uang-uang_jaminan'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('uang_jaminan') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Nilai Limit <sup class="sup-required">*</sup></label>
                                <input type="text" id="nilai_limit" name="nilai_limit" class="form-control" value="{{ old('nilai_limit') }}">
                                @if($errors->has('nilai_limit'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nilai_limit') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label for="">Nama Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" value="{{ old('nama_pembeli') }}">
                                @if($errors->has('nama_pembeli'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('nama_pembeli') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Alamat Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="alamat_pembeli" name="alamat_pembeli" class="form-control" value="{{ old('alamat_pembeli') }}">
                                @if($errors->has('alamat_pembeli'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('alamat_pembeli') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">No. KTP <sup class="sup-required">*</sup></label>
                                <input type="text" id="no_ktp" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}">
                                @if($errors->has('no_ktp'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('no_ktp') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Harga Lelang <sup class="sup-required">*</sup></label>
                                <input type="text" id="harga_lelang" name="harga_lelang" class="form-control" value="{{ old('harga_lelang') }}">
                                @if($errors->has('harga_lelang'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('harga_lelang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Bea Lelang Penjual <sup class="sup-required">*</sup></label>
                                <input type="text" id="bea_penjual" name="bea_penjual" class="form-control" value="{{ old('bea_penjual') }}">
                                @if($errors->has('bea_penjual'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('bea_penjual') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Bea Lelang Pembeli <sup class="sup-required">*</sup></label>
                                <input type="text" id="bea_pembeli" name="bea_pembeli" class="form-control" value="{{ old('bea_pembeli') }}">
                                @if($errors->has('bea_pembeli'))
                                    <span class="text-danger custom-error-size">{{ $errors->first('bea_pembeli') }}</span>
                                @endif
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
@endsection
