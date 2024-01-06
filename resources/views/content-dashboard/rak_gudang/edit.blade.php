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
@include('layouts.overview',['text' => 'Edit Rak Gudang','icon' => 'mdi mdi-airplay'])
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
                    <form class="forms-sample" action="{{ route('rak_gudang.update', Request::segment(4, 'default')) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama <sup class="sup-required">*</sup></label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $data->nama_gudang }}">
                            @if($errors->has('nama'))
                                <span class="text-danger custom-error-size">{{ $errors->first('nama') }}</span>
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
