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
@include('layouts.overview',['text' => 'Edit Nomor Rak','icon' => 'mdi mdi-airplay'])
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
                    <form class="forms-sample" action="{{ route('rak_detail.update', Request::segment(4, 'default')) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="">Nama Gudang<sup class="sup-required">*</sup></label>
                            <select name="gudang" id="gudang" class="form-control">
                                @foreach ($gudang as $key => $item)
                                    <option value="{{ $key }}" {{ $data->rak_gudang_id == $key ? 'selected' : '' }}>{{ $item->nama_gudang }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gudang'))
                                <span class="text-danger custom-error-size">{{ $errors->first('gudang') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Nomor Rak <sup class="sup-required">*</sup></label>
                            <input type="text" id="nomor" name="nomor" class="form-control" value="{{ $data->no_rak }}">
                            @if($errors->has('nomor'))
                                <span class="text-danger custom-error-size">{{ $errors->first('nomor') }}</span>
                            @endif
                        </div>

                        <a href="{{route('rak_gudang.index')}}" class="btn btn-blue-material mr-2">Kembali</a>
                        <button type="submit" class="btn bg-green mr-2 text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
