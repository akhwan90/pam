@extends('layout.app')

@section('title', 'Setting')

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
                        
                        {!! Form::open(['url'=>url('admin/setting/settingSave')]) !!}

                        @foreach ($settings as $item)
                            <div class="form-group">
                                <label for="">{{ $item->label }}</label>
                                {!! Form::hidden('name[]', $item->name) !!}
                                {!! Form::text('value[]', $item->value, ['class'=>'form-control']) !!}
                                <small class="text-info font-italic">{{ $item->keterangan }}</small>
                            </div>
                        @endforeach
                        
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