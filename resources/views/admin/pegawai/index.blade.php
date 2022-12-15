@extends('layout.app')

@section('title', 'Data Pegawai')

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
                        <a href="{{ url('admin/pegawai/add') }}" class="btn btn-outline-primary mb-2"><i class="fa fa-plus"></i> Tambah Pegawai</a>

                        <div class="table-responsive overflow-visible">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">NIP</th>
                                    <th width="30%">Nama</th>
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
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('admin/pegawai/edit/'.$item->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{ url('admin/pegawai/remove/'.$item->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Anda yakin..?')"><i class="fa fa-times"></i> Hapus</a>
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