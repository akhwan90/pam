<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GolonganTarif;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GolonganTarifController extends Controller
{
    //
    //

    public function index()
    {
        $data['menuAktif'] = 'golonganTarif';
        $data['datas'] = GolonganTarif::paginate(100);

        return view('admin.golongan_tarif.index', $data);
    }

    public function add()
    {
        $data['menuAktif'] = 'golonganTarif';
        return view('admin.golongan_tarif.add', $data);
    }

    public function edit($idData)
    {
        $data['menuAktif'] = 'golonganTarif';
        $data['data'] = GolonganTarif::whereId($idData)->first();

        return view('admin.golongan_tarif.edit', $data);
    }

    public function addSave()
    {
        $credentials = request()->validate([
            'nama' => ['required'],
            'tarif' => ['required'],
        ]);

        GolonganTarif::insert([
            'nama' => request('nama'),
            'tarif' => request('tarif'),
            'created_at' => Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/golonganTarif');
    }

    public function editSave()
    {
        $credentials = request()->validate([
            'nama' => ['required'],
            'tarif' => ['required'],
        ]);

        GolonganTarif::whereId(request('id'))->update([
            'nama' => request('nama'),
            'tarif' => request('tarif'),
            'updated_at' => Carbon::now('utc')->toDateTimeString()
        ]);


        return redirect('admin/golonganTarif');
    }

    public function remove($idData)
    {
        GolonganTarif::whereId($idData)->delete();
        return redirect('admin/golonganTarif');
    }
}
