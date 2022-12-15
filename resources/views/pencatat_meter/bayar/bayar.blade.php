@extends('layout.app')

@section('title', 'Pembayaran Tagihan')

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
                        
                        {!! Form::open(['url'=>url('pencatatMeter/pembayaran/bayarSave')]) !!}
                        {!! Form::hidden('idPelanggan', $detilPelanggan->id) !!}
                        {!! Form::hidden('tahun', $posisiMeterPeriodeSekarang->periode_tahun) !!}
                        {!! Form::hidden('bulan', $posisiMeterPeriodeSekarang->periode_bulan) !!}
                    
                        <table class="table table-sm">
                            <tr>
                                <td>ID Pelanggan</td>
                                <td>{{ $detilPelanggan->id }}</td>
                            </tr>
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
                                <td>Periode</td>
                                <td>{{ getBulanIndo($posisiMeterPeriodeSekarang->periode_bulan)." ".$posisiMeterPeriodeSekarang->periode_tahun }}</td>
                            </tr>
                            <tr>
                                <td>Posisi Meter Awal</td>
                                <td>{{ round($posisiMeterPeriodeSekarang->posisi_meter - $posisiMeterPeriodeSekarang->penggunaan) }}</td>
                            </tr>
                            <tr>
                                <td>Posisi Meter Akhir</td>
                                <td>{{ round($posisiMeterPeriodeSekarang->penggunaan) }}</td>
                            </tr>
                            <tr>
                                <td>Penggunaan</td>
                                <td>{{ round($posisiMeterPeriodeSekarang->posisi_meter) }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Penggunaan</td>
                                <td>{{ round($posisiMeterPeriodeSekarang->penggunaan_tarif) }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Beban</td>
                                <td>{{ round($detilPelanggan->tarif_beban) }}</td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Yang harus dibayarkan</label>
                                    {!! Form::number('yang_harus_dibayar', round($detilPelanggan->tarif_beban + $posisiMeterPeriodeSekarang->penggunaan_tarif), ['class'=>'form-control form-control-lg', 'id'=>'yang_harus_dibayar']) !!}
                                </div>
                            </div>

                        </div>
                        
                        <div class="form-group mt-2">
                            <button class="btn btn-outline-primary btn-lg" type="submit"><i class="fa fa-check"></i> Bayarkan</button>
                            <a href="{{ url('pencatatMeter/catatMeter') }}" class="btn btn-outline-secondary btn-lg"><i class="fa fa-arrow-left"></i> Kembali</a>
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