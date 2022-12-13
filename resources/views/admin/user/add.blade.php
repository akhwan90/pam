@extends('layout.app')

@section('title', 'Tambah Data User')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                    </div>
                    <div class="card-body">
                        
                        @if ($errors->isNotEmpty())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                        
                        {!! Form::open(['url'=>url('admin/user/addSave')]) !!}
                        <div class="form-group">
                            <label for="">Username</label>
                            {!! Form::text('username', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            {!! Form::text('name', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            {!! Form::text('password', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Level</label>
                            {!! Form::select('level', ['pegawai'=>'Pegawai', 'admin'=>'Admin'], '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary" type="submit"><i class="fa fa-check"></i> Simpan</button>
                            <a href="{{ url('admin/user') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection