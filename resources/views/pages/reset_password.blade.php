@extends('layout.app')

@section('title', 'Reset Password')
{{-- @section('title', 'Aplikasi E-PAK - JFT Pranata Komputer') --}}

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

                        {!! session('notif') !!}
                        
                        {!! Form::open(['url'=>url('resetPasswordSave')]) !!}
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            {!! Form::text('p1', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            {!! Form::text('p2', '', ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Ulangi Password Baru</label>
                            {!! Form::text('p3', '', ['class'=>'form-control']) !!}
                        </div>
                        
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary" type="submit"><i class="fa fa-check"></i> Ubah</button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection