<?php

namespace App\Http\Controllers;

use App\Models\GolonganTarif;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


class PelangganController extends Controller
{
    public function index()
    {
        $data['menuAktif'] = 'pelanggan';
        $data['pegawais'] = Pelanggan::paginate(100);

        return view('admin.pelanggan.index', $data);
    }

    public function add()
    {
        $data['menuAktif'] = 'pelanggan';
        $data['pGolonganTarif'] = GolonganTarif::pluck('nama', 'id')->toArray();
        return view('admin.pelanggan.add', $data);
    }

    public function edit($idPegawai)
    {
        $data['menuAktif'] = 'pelanggan';
        $data['pGolonganTarif'] = GolonganTarif::pluck('nama', 'id')->toArray();
        $data['pelanggan'] = Pelanggan::whereId($idPegawai)->first();

        return view('admin.pelanggan.edit', $data);
    }

    public function addSave()
    {
        $credentials = request()->validate([
            'nama' => ['required'],
            'alamat_dusun' => ['required'],
            'alamat_rt' => ['required'],
            'alamat_rw' => ['required'],
            'alamat_desa' => ['required'],
            'alamat_kecamatan' => ['required'],
            'nomor_hp' => ['required'],
            'golongan_tarif_id' => ['required'],
        ]);

        Pelanggan::insert([
            'id'=>date('YmdHis'),
            'nama' => request('nama'),
            'alamat_dusun' => request('alamat_dusun'),
            'alamat_rt' => request('alamat_rt'),
            'alamat_rw' => request('alamat_rw'),
            'alamat_desa' => request('alamat_desa'),
            'alamat_kecamatan' => request('alamat_kecamatan'),
            'nomor_hp' => request('nomor_hp'),
            'golongan_tarif_id' => request('golongan_tarif_id'),
            'created_at' => Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/pelanggan');
    }

    public function editSave()
    {
        $credentials = request()->validate([
            'nama' => ['required'],
            'alamat_dusun' => ['required'],
            'alamat_rt' => ['required'],
            'alamat_rw' => ['required'],
            'alamat_desa' => ['required'],
            'alamat_kecamatan' => ['required'],
            'nomor_hp' => ['required'],
            'golongan_tarif_id' => ['required'],
        ]);

        Pelanggan::whereId(request('id'))->update([
            'nama' => request('nama'),
            'alamat_dusun' => request('alamat_dusun'),
            'alamat_rt' => request('alamat_rt'),
            'alamat_rw' => request('alamat_rw'),
            'alamat_desa' => request('alamat_desa'),
            'alamat_kecamatan' => request('alamat_kecamatan'),
            'nomor_hp' => request('nomor_hp'),
            'golongan_tarif_id' => request('golongan_tarif_id'),
            'updated_at' => Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/pelanggan');
    }

    public function remove($idPegawai)
    {
        Pelanggan::whereId($idPegawai)->delete();
        return redirect('admin/pelanggan');
    }

    public function cetakQr($idPelanggan)
    {
        $getPelanggan = Pelanggan::whereId($idPelanggan)->first();

        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($idPelanggan)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText($getPelanggan->nama." - ".$getPelanggan->alamat_dusun.", RT: ".$getPelanggan->alamat_rt)
        ->labelFont(new NotoSans(15))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();

        $dataUri = $result->getDataUri();

        echo '<img src="'.$dataUri.'">';
    }
}
