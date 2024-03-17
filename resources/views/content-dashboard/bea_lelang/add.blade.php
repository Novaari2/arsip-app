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
@include('layouts.overview',['text' => 'Tambah Bea Lelang','icon' => 'mdi mdi-airplay'])
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
                    <form class="forms-sample" action="{{ route('bea_lelang.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama <sup class="sup-required">*</sup></label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}">
                            @if($errors->has('nama'))
                                <span class="text-danger custom-error-size">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Tipe <sup class="sup-required">*</sup></label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">Pilih Tipe</option>
                                <option value="BTB">BTB</option>
                                <option value="BB">BB</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Bea Penjual <sup class="sup-required">*</sup></label>
                            <input type="number" id="bea_penjual" step="any" name="bea_penjual" class="form-control" value="{{ old('bea_penjual') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Bea Pembeli <sup class="sup-required">*</sup></label>
                            <input type="number" id="bea_pembeli" step="any" name="bea_pembeli" class="form-control" value="{{ old('bea_pembeli') }}">
                        </div>

                        <a href="{{route('bea_lelang.index')}}" class="btn btn-blue-material mr-2">Kembali</a>
                        <button type="submit" class="btn bg-green mr-2 text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
