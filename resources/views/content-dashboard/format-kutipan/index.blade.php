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
            <a href="{{ route('format.kutipan') }}" class="btn btn-sm bg-green text-white mb-4"><i class="mdi mdi-airplus"></i>Cetak Pdf</a>
            <form action="" class="forms-sample">
                <div class="form-group">
                    <label for="">Input Kepala Kantor</label>
                    <input type="text" name="kepala_kantor" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Input Saksi I</label>
                    <input type="text" name="saksi_1" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Input Saksi II</label>
                    <input type="text" name="saksi_2" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Masukkan Catatan</label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection