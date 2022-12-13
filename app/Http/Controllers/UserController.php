<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    //

    public function index()
    {
        $data['menuAktif'] = 'user';
        $data['users'] = User::paginate(100);

        return view('admin.user.index', $data);
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
