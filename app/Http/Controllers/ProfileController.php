<?php

namespace App\Http\Controllers;

use App\Models\JftGroup;
use App\Models\JftJenjang;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    //

    public function settingJft()
    {   
        $getGroupJft = JftGroup::pluck('nama', 'group_id');
        $getDetil = Pegawai::where('user_id', Auth::user()->id)->first();

        $data['pJenjangJft'] = [];
        $data['disabled'] = true;
        if (!empty($getDetil)) {
            $getJenjangTerpilih = JftJenjang::join('jft_2_kategori', 'jft_3_jenjang.kategori_id', '=', 'jft_2_kategori.kategori_id')
            ->where('jft_2_kategori.group_id', $getDetil->jft_group_id)
            ->pluck('jft_3_jenjang.nama', 'jft_3_jenjang.jenjang_id')
            ->toArray();
            
            $data['disabled'] = false;
            $data['pJenjangJft'] = $getJenjangTerpilih; 
        }

        $data['menuAktif'] = 'settingJft';
        $data['detil'] = $getDetil;
        $data['pGroupJft'] = $getGroupJft->prepend('-', '')->toArray();
        return view('pegawai.profile.setting_jft', $data);
    }

    public function settingJftSave()
    {
        $credentials = request()->validate([
            'jft_group_id' => ['required'],
            'jft_jenjang_id' => ['required'],
        ]);

        Pegawai::where('id', request('id_pegawai'))
        ->update([
            'jft_group_id' => request('jft_group_id'),
            'jft_jenjang_id' => request('jft_jenjang_id'),
        ]);

        return redirect()->back();
    }

    public function getJenjangByGroupJft($groupId)
    {
        $getJenjangByGroupJft = JftJenjang::join('jft_2_kategori', 'jft_3_jenjang.kategori_id', '=', 'jft_2_kategori.kategori_id')
        ->where('jft_2_kategori.group_id', $groupId)
        ->select('jft_3_jenjang.nama', 'jft_3_jenjang.jenjang_id')->get();

        return response()->json($getJenjangByGroupJft);
    }

    public function add()
    {
        $data['menuAktif'] = 'user';

        return view('admin.user.add', $data);
    }

    public function edit($idUser)
    {
        $data['menuAktif'] = 'user';
        $data['user'] = User::whereId($idUser)->first();

        return view('admin.user.edit', $data);
    }

    public function addSave()
    {
        $credentials = request()->validate([
            'username' => ['required', 'min:6', 'unique:users,email'],
            'name' => ['required'],
            'password' => ['required', 'min:6'],
            'level'=>['required']
        ]);

        User::insert([
            'name'=>request('name'),
            'email'=>request('username'),
            'password'=>password_hash(request('password'), PASSWORD_DEFAULT),
            'level' => request('level'),
            'created_at'=> Carbon::now('utc')->toDateTimeString()
        ]);

        return redirect('admin/user');
    }

    public function editSave()
    {
        $credentials = request()->validate([
            'username' => ['required', 'min:6', 'unique:users,email,'. request('id')],
            'name' => ['required'],
            'level' => ['required']
        ]);

        $dataUser = [
            'name' => request('name'),
            'email' => request('username'),
            'level' => request('level'),
            'created_at' => Carbon::now('utc')->toDateTimeString()
        ];

        if (!empty(request('username'))) {
            $dataUser['password'] = password_hash(request('password'), PASSWORD_DEFAULT);
        }

        User::whereId(request('id'))->update($dataUser);

        return redirect('admin/user');
    }

    public function remove($idUser)
    {
        User::whereId($idUser)->delete();
        return redirect('admin/user');
    }
}
