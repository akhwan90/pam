<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-PAMSIMAS - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('asset/') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset/') }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center mt-3">
                                        <h1 class="h4 text-gray-900 mb-4">Cek Rekening</h1>
                                    </div>
                                    <form method="post" action="{{ url('cekRekeningDo') }}" class="user">
                                        @csrf

                                        {!! session('notif') !!}

                                        @if ($errors->isNotEmpty())
                                            <div class="alert alert-warning">{{ $errors->first() }}</div>
                                        @endif

                                        <div class="form-group">
                                            <input type="text" name="noRekening" class="form-control form-control-user text-center"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan kode rekening" autofocus
                                                value="{{ $nomorRekening }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block"><i class="fa fa-check"></i> Cek</button>
                                        <a href="{{ url('login') }}" class="btn btn-warning btn-user btn-block"><i class="fa fa-arrow-left"></i> Kembali Ke Login</a>
                                    </form>

                                    
                                    @if (!empty($dataRekenings))
                                        <h5 class="mt-3">Pelanggan</h5>
                                        <table class="table table-bordered table-sm mt-3">
                                            <tr>
                                                <td width="30%">Nama</td>
                                                <td width="70%">{{ $pelanggan->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>{{ $pelanggan->alamat_dusun.", RT: ".$pelanggan->alamat_rt."/RW: ".$pelanggan->alamat_rw }}</td>
                                            </tr>
                                        </table>
                                        
                                        <h5 class="mt-3">Pembayaran</h5>
                                        <table class="table table-bordered table-sm mt-3">
                                            <thead>
                                                <tr>
                                                    <th width="50%" class="text-center">Periode</th>
                                                    <th width="30%" class="text-center">Jumlah Bayar</th>
                                                    <th width="20%" class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($dataRekenings as $item)
                                                <tr>
                                                    <td class="pl-4">{{ getBulanIndo($item->periode_bulan)." ".$item->periode_tahun }}</td>
                                                    <td class="text-center">{{ number_format($item->penggunaan_tarif + $item->penggunaan_beban) }}</td>
                                                    <td class="text-center">
                                                        @if ($item->status_bayar == 1)
                                                            <i class="fa fa-check text-success"></i> Sudah Dibayar
                                                        @else
                                                            <i class="fa fa-minus-circle text-danger"></i> Belum dibayar
                                                        @endif    
                                                    </td>
                                                </tr>
                                            @endforeach    
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('asset/') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset/') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('asset/') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('asset/') }}/js/sb-admin-2.min.js"></script>

</body>

</html>