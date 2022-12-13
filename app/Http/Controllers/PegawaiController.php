<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    //

    public function index()
    {
        $data['menuAktif'] = 'pegawai';
        $data['pegawais'] = Pegawai::paginate(100);

        return view('admin.pegawai.index', $data);
    }

    public function add()
    {
        $data['menuAktif'] = 'pegawai';
        $getRefUser = User::pluck('email', 'id');
        
        $data['pUser'] = $getRefUser->prepend('-Tanpa user-', '')->toArray();

        return view('admin.pegawai.add', $data);
    }

    public function edit($idPegawai)
    {
        $data['menuAktif'] = 'pegawai';
        $getRefUser = User::pluck('email', 'id');

        $data['pUser'] = $getRefUser->prepend('-Tanpa user-', '')->toArray();
        $data['pegawai'] = Pegawai::whereId($idPegawai)->first();

        return view('admin.pegawai.edit', $data);
    }

    public function addSave()
    {
        $credentials = request()->validate([
            'nip' => ['required', 'unique:pegawais,nip'],
            // 'user_id' => ['required'],
            'nama' => ['required'],
            'nomor_hp' => ['required'],
        ]);

        Pegawai::insert([
            'nip'=>request('nip'),
            'user_id'=>request('user_id'),
            'nama'=>request('nama'),
            'nomor_hp'=>request('nomor_hp'),
            'created_at'=> Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/pegawai');
    }

    public function editSave()
    {
        $credentials = request()->validate([
            'nip' => ['required', 'unique:pegawais,nip,'.request('id')],
            // 'user_id' => ['required'],
            'nomor_hp' => ['required'],
        ]);

        Pegawai::whereId(request('id'))->update([
            'nip' => request('nip'),
            'user_id' => request('user_id'),
            'nama' => request('nama'),
            'nomor_hp' => request('nomor_hp'),
            'updated_at' => Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/pegawai');
    }

    public function remove($idPegawai)
    {
        Pegawai::whereId($idPegawai)->delete();
        return redirect('admin/pegawai');
    }
}
