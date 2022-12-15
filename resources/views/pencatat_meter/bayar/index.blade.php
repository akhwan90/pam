@extends('layout.app')

@section('title', 'Pembayaran '.getBulanIndo($periode['bulan']).' '.$periode['tahun'])

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
                        {!! session('error') !!}

                        <form method="get" class="row mb-2">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="basic-url" class="form-label">Lihat Periode</label>
                                    <input type="month" name="periode" class="form-control" value="{{ request('periode') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-outline-primary">Lihat</button>
                            </div>
                        </form>


                        <div class="table-responsive overflow-visible">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center" width="5%" rowspan="2">No</th>
                                    <th class="text-center" width="15%" rowspan="2">ID Pelanggan</th>
                                    <th class="text-center" width="25%" rowspan="2">Nama / Gol. Tarif</th>
                                    <th class="text-center" width="10%" rowspan="2">Posisi Periode Ini</th>
                                    <th class="text-center" width="30%" colspan="3">Biaya</th>
                                    <th class="text-center" width="15%" rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="text-center" width="10%">Penggunaan</th>
                                    <th class="text-center" width="10%">Beban</th>
                                    <th class="text-center" width="10%">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse ($datas as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            {{ $item->pelanggan_id }} 
                                        </td>
                                        <td>
                                            {{ $item->nama }}
                                            <small class="badge bg-secondary text-white">{{ $item->nama_golongan_tarif }}</small>
                                        </td>
                                        <td class="text-center">{{ number_format($item->penggunaan) }}</td>
                                        <td class="text-right">{{ number_format($item->penggunaan * $item->tarif ) }}</td>
                                        <td class="text-right">{{ number_format($item->biaya_beban) }}</td>
                                        <td class="text-right">{{ number_format($item->biaya_beban + ($item->penggunaan * $item->tarif)) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if ($item->status_bayar == 0)
                                                @if (!empty($item->id_catat))
                                                    <a href="{{ url('pencatatMeter/pembayaran/bayar/'.$item->pelanggan_id.'?tahun='.$item->periode_tahun.'&bulan='.$item->periode_bulan) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-arrow-right"></i> Bayar</a>                      
                                                @endif

                                                @else            
                                                    <div class="badge bg-success p3 text-white"><i class="fa fa-check"></i> Sudah Dibayar</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    @php
                                        $no++;
                                    @endphp
                                    @empty
                                    <tr><td colspan="4" class="text-secondary">- belum ada data -</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- pagination --}}
                        <div class="row d-flex justify-content-between mt-2">
                            <div class="col-auto fw-bold">Total : {{ $datas->total() }} data </div>
                            <div class="col-auto">
                                {{ $datas->withQueryString()->links() }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection