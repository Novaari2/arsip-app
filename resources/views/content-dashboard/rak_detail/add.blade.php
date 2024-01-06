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
@include('layouts.overview',['text' => 'Tambah Nomor Rak','icon' => 'mdi mdi-airplay'])
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
                    <form class="forms-sample" action="{{ route('rak_detail.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Gudang<sup class="sup-required">*</sup></label>
                            <select name="gudang" id="gudang" class="form-control">
                                <option value="">Pilih Gudang</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id }}" {{ old('gudang') == $item->id ? 'selected' : '' }}>{{ $item->nama_gudang }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gudang'))
                                <span class="text-danger custom-error-size">{{ $errors->first('gudang') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Nomor Rak<sup class="sup-required">*</sup></label>
                            <input type="text" id="nomor" name="nomor" class="form-control" value="{{ old('nomor') }}">
                            @if($errors->has('nomor'))
                                <span class="text-danger custom-error-size">{{ $errors->first('nomor') }}</span>
                            @endif
                        </div>

                        <a href="{{route('rak_detail.index')}}" class="btn btn-blue-material mr-2">Kembali</a>
                        <button type="submit" class="btn bg-green mr-2 text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
