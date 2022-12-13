@extends('layout.app')

@section('title', 'Tambah Data Pegawai')

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
                        
                        {!! Form::open(['url'=>url('admin/pegawai/addSave')]) !!}
                        <div class="form-group">
                            <label for="">NIP</label>
                            {!! Form::text('nip', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">User ID</label>
                            {!! Form::select('user_id', $pUser, '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            {!! Form::text('nama', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Nomor HP</label>
                            {!! Form::text('nomor_hp', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary" type="submit"><i class="fa fa-check"></i> Simpan</button>
                            <a href="{{ url('admin/pegawai') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection