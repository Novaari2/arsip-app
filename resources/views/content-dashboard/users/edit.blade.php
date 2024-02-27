@extends('layouts.app')

@section('content')
    @include('layouts.overview',['text' => 'Edit User', 'icon' => 'mdi-account'])
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
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
                      <form class="forms-sample" action="{{route('user.update', Request::segment(4, 'default'))}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="fullname">Nama Lengkap <sup style="color:red">*</sup></label>
                          <input type="text" class="form-control" id="fullname" placeholder="Nama Lengkap..." name="fullname" value="{{ $user->fullname }}" required>
                          @if ($errors->has('fullname'))
                              <span class="text-danger custom-error-size">{{ $errors->first('fullname') }}</span>
                          @endif
                        </div>
                        <div class="form-group">
                          <label for="username">Username <sup style="color:red">*</sup></label>
                          <input type="text" class="form-control" id="username" placeholder="Username..." name="username" value="{{ $user->username }}" required>
                          @if ($errors->has('username'))
                              <span class="text-danger custom-error-size">{{ $errors->first('username') }}</span>
                          @endif
                        </div>
                        <div class="form-group">
                          <label for="email">Email <sup style="color:red">*</sup></label>
                          <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$user->email }}" required>
                          @if ($errors->has('email'))
                              <span class="text-danger custom-error-size">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                        <div class="form-group">
                          <label for="exampleSelectGender">Role <sup style="color:red">*</sup></label>
                          <select class="form-control" id="role" name="role" required>
                            <option value="" {{$user->role == '' || $user->role == null ? 'selected' : ''}}>-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}" {{$user->role == $role->id ? 'selected' : ''}}>{{ucwords($role->name)}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <span class="text-muted" style="font-size:11px">Keterangan: <sup style="color:red">*</sup> (wajib diisi)</span>
                        </div>
                        <a href="{{route('user.index')}}" class="btn btn-blue-material mr-2">Kembali</a>
                        <button type="submit" class="btn bg-green mr-2 text-white">Submit</button>

                      </form>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <br>
@endsection


