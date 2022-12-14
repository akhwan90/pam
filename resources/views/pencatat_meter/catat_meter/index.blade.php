@extends('layout.app')

@section('title', 'Catat Meter Periode '.$periode['bulan'].'-'.$periode['tahun'])

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

                        <div class="table-responsive overflow-visible">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">ID Pelanggan</th>
                                    <th width="30%">Nama</th>
                                    <th width="15%">Posisi Periode Ini</th>
                                    <th width="15%">Jumlah Bayar</th>
                                    <th width="15%">Aksi</th>
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
                                            <small class="badge bg-info">{{ $item->nama_golongan_tarif }}</small>
                                        </td>
                                        <td>{{ number_format($item->posisi_meter) }}</td>
                                        <td>{{ number_format($item->posisi_meter * $item->tarif ) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if (empty($item->id_catat))
                                                    <a href="{{ url('pencatatMeter/catatMeter/add/'.$item->pelanggan_id) }}" class="btn btn-outline-primary"><i class="fa fa-edit"></i> Catat</a>              
                                                @else
                                                    <a href="{{ url('pencatatMeter/catatMeter/edit/'.$item->pelanggan_id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>              
                                                    
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