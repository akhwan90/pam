@extends('layout.app')

@section('title', 'Catat Meter')

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
                        
                        {!! Form::open(['url'=>url('pencatatMeter/catatMeter/addSave')]) !!}
                        {!! Form::hidden('idPelanggan', $detilPelanggan->id) !!}
                        {!! Form::hidden('tarif', $detilPelanggan->tarif, ['id'=>'tarif']) !!}
                        {!! Form::hidden('posisiPeriodeSebelumnya', $posisiMeterSebelumnya, ['id'=>'posisiPeriodeSebelumnya']) !!}
                    
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Nama Pelanggan</td>
                                <td width="70%">{{ $detilPelanggan->nama }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $detilPelanggan->alamat_dusun.", RT: ".$detilPelanggan->alamat_rt."/RW: ".$detilPelanggan->alamat_rw }}</td>
                            </tr>
                            <tr>
                                <td>Golongan Tarif</td>
                                <td>{{ $detilPelanggan->nama_golongan_tarif." (".number_format($detilPelanggan->tarif)."/m3) " }}</td>
                            </tr>
                            <tr>
                                <td>Posisi Meter Sebelumnya</td>
                                <td>{{ $posisiMeterSebelumnya }}</td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Posisi Meter Sekarang</label>
                                    {!! Form::number('posisi_sekarang', $posisiMeterEdit, ['class'=>'form-control', 'id'=>'posisi_sekarang']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Jumlah Penggunaan</label>
                                    {!! Form::number('jumlah_penggunaan', 0, ['class'=>'form-control', 'id'=>'jumlah_penggunaan', 'readonly'=>true]) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Yang Harus Dibayarkan</label>
                                    {!! Form::number('jumlah_dibayar', 0, ['class'=>'form-control', 'id'=>'jumlah_dibayar', 'readonly'=>true]) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary" type="submit"><i class="fa fa-check"></i> Simpan</button>
                            <a href="{{ url('pencatatMeter/catatMeter') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#posisi_sekarang").on('blur', function() {
            
            let posisiSekarangValue = parseInt($(this).val());

            let tarif = parseInt($("#tarif").val());
            let posisiSebelumnyaValue = parseInt($("#posisiPeriodeSebelumnya").val());

            $("#jumlah_penggunaan").val(posisiSekarangValue-posisiSebelumnyaValue);
            $("#jumlah_dibayar").val(((posisiSekarangValue-posisiSebelumnyaValue) * tarif));
        });
    </script>
@endsection