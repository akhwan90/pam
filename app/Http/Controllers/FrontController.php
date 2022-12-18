<?php

namespace App\Http\Controllers;

use App\Models\CatatMeter;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function cekRekening()
    {
        $data['nomorRekening'] = '';
        return view('cek_rekening', $data);
    }
    
    public function cekRekeningDo()
    {
        $nomorRekening = request('noRekening');

        $getDataRekening = CatatMeter::where('pelanggan_id', $nomorRekening)
        ->orderBy('created_at', 'desc')
        ->get();
        $data['dataRekenings'] = $getDataRekening;
        $data['pelanggan'] = Pelanggan::whereId($nomorRekening)->first();
        $data['nomorRekening'] = $nomorRekening;

        return view('cek_rekening', $data);
    }

    
}
