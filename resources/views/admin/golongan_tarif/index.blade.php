@extends('layout.app')

@section('title', 'Golongan Tarif Pelanggan')

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
                        <a href="{{ url('admin/golonganTarif/add') }}" class="btn btn-outline-primary mb-2"><i class="fa fa-plus"></i> Tambah Golongan</a>

                        <div class="table-responsive overflow-visible">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="55%">Nama</th>
                                    <th width="20%">Tarif</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse ($datas as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->tarif }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('admin/golonganTarif/edit/'.$item->id) }}" class="btn btn-outline-primary"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{ url('admin/golonganTarif/remove/'.$item->id) }}" class="btn btn-outline-danger" onclick="return confirm('Anda yakin..?')"><i class="fa fa-times"></i> Hapus</a>
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