@extends('layout.app')

@section('title', 'Edit Data Pelanggan')

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
                        
                        {!! Form::open(['url'=>url('admin/pelanggan/editSave')]) !!}
                        {!! Form::hidden('id', $pelanggan->id) !!}
                        <div class="form-group">
                            <label for="">Nama</label>
                            {!! Form::text('nama', $pelanggan->nama, ['class'=>'form-control']) !!}
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Dusun</label>
                                    {!! Form::text('alamat_dusun', $pelanggan->alamat_dusun, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">RT</label>
                                    {!! Form::text('alamat_rt', $pelanggan->alamat_rt, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">RW</label>
                                    {!! Form::text('alamat_rw', $pelanggan->alamat_rw, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Desa</label>
                                    {!! Form::text('alamat_desa', $pelanggan->alamat_desa, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Kecamatan</label>
                                    {!! Form::text('alamat_kecamatan', $pelanggan->alamat_kecamatan, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Nomor HP</label>
                            {!! Form::text('nomor_hp', $pelanggan->nomor_hp, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Golongan Tarif</label>
                            {!! Form::select('golongan_tarif_id', $pGolonganTarif, $pelanggan->golongan_tarif_id, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary" type="submit"><i class="fa fa-check"></i> Simpan</button>
                            <a href="{{ url('admin/pelanggan') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection