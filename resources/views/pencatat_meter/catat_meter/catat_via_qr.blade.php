@extends('layout.app')

@section('title', 'Catat Meter QR Code')

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
                        <div class="alert alert-info"><i class="bx bx-camera"></i> Berikan izin, jika ada permintaan mengaktifkan kamera, kemudian arahkan kamera smartphone Anda, ke QR code yang ditampilkan di surat.</div>
                        <select name="options" class="form-control mb-1">
                            <option value="2">Kamera Belakang</option>
                            <option value="1">Kamera Depan</option>
                        </select>
                        <video id="preview" poster="https://kunjungan.kulonprogokab.go.id/images/loading.gif" style="width: 100%"></video>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    
    <script src="{{ asset('asset/') }}/js/instascan.min.js"></script>

    <script type="text/javascript">
    	let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 1, mirror: false });

    	scanner.addListener('scan',function(content){
            // alert(content); 
    		window.location.href = "{{ url('pencatatMeter/catatMeter/edit') }}/"+content;
		});

    	Instascan.Camera.getCameras().then(function (cameras){
    		var cameraCount = cameras.length;
    		var lastCamera = cameraCount -1;
    		if(cameraCount>0){ 
    			scanner.start(cameras[lastCamera]);
    			$('[name="options"]').on('change',function(){
				//scanner.stop();
				if($(this).val()==1){
					if(cameras[0]!=""){
						scanner.start(cameras[0]);
					}else{
						alert('No Front camera found!');
					}
				}else if($(this).val()==2){
					if(cameras[lastCamera]!=""){
						scanner.start(cameras[lastCamera]);
					}else{
						alert('No Back camera found!');
					}
				}
              	});
    		}else{
    			console.error('Kamera tidak ditemukan, atau anda belum "Izinkan Kamera"');
    			alert('Kamera tidak ditemukan, atau anda belum "Izinkan Kamera"');
    		}
    	}).catch(function(e){
    		if(e=='Error: Cannot access video stream (NotAllowedError).'){
    			var msg='Kamera tidak bisa diakses. Anda harus Izinkan (Allow) akses kamera di setelan browser anda..';
    			console.error(msg);
    			alert(msg);
    			alert(e);
    		}else{
    			console.error(e);
    			alert(e);
    		}
    	});
    </script>
@endsection