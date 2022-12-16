@extends('layout.app')

@section('title', 'Data Pelanggan')

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
                        <a href="{{ url('admin/pelanggan/add') }}" class="btn btn-outline-primary mb-2"><i class="fa fa-plus"></i> Tambah Pelanggan</a>

                        <div class="table-responsive overflow-visible">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">No Pelanggan</th>
                                    <th width="20%">Nama</th>
                                    <th width="15%">Dusun</th>
                                    <th width="10%">RT/RW</th>
                                    <th width="10%">Nomor HP</th>
                                    <th width="25%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse ($pegawais as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->alamat_dusun }}</td>
                                        <td>{{ $item->alamat_rt }} / {{ $item->alamat_rw }}</td>
                                        <td>{{ $item->nomor_hp }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('admin/pelanggan/edit/'.$item->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{ url('admin/pelanggan/remove/'.$item->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Anda yakin..?')"><i class="fa fa-times"></i> Hapus</a>
                                                <a href="{{ url('admin/pelanggan/cetakQr/'.$item->id) }}" class="btn btn-outline-success btn-sm" target="_blank"><i class="fa fa-qrcode"></i> Cetak QR</a>
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
                            <div class="col-auto fw-bold">Total : {{ $pegawais->total() }} data </div>
                            <div class="col-auto">
                                {{ $pegawais->withQueryString()->links() }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection