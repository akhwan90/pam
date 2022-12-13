@extends('layout.app')

@section('title', 'Aplikasi')
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
                        @yield('title')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection