<?php

namespace App\Http\Controllers;

use App\Models\GolonganTarif;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelangganController extends Controller
{
    //

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
}
