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
@include('layouts.overview', ['text' => 'Format Kuitansi', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ route('format.kutipan' }}" class="btn btn-sm bg-green text-white mb-4" target="_blank"><i class="mdi mdi-airplus"></i>Cetak Pdf</a> --}}
            <form action="{{ route('kuitansi.kuitansi', Request::segment(4, 'default')) }}" method="POST" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="">Input Nama Atasan Bendahara</label>
                    <input type="text" name="kepala_kantor" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Input Nama Bendahara</label>
                    <input type="text" name="saksi_1" id="" class="form-control">
                </div>
                <button class="btn btn-sm bg-green text-white mb-4" target="_blank"><i class="mdi mdi-airplus"></i>Cetak Pdf</button>
            </form>
        </div>
    </div>
</div>
@endsection
