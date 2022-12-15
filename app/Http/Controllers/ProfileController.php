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

    public function resetPassword()
    {
        $data['menuAktif'] = '';
        return view('pages.reset_password', $data);
    }

    public function resetPasswordSave()
    {
        $credentials = request()->validate([
            'p1' => ['required', 'min:6'],
            'p2' => ['required', 'min:6', 'same:p3'],
            'p3' => ['required', 'min:6'],
        ], [
            'p1.required'=>'Password lama diperlukan',
            'p1.min'=>'Password lama minimal 6 karakter',
            'p2.required' => 'Password baru diperlukan',
            'p2.min' => 'Password baru minimal 6 karakter',
            'p2.same' => 'Konfirmasi password baru harus sama',
        ]);

        // cek password lama
        
        if (password_verify(request('p1'), Auth::user()->password)) {
            $updatePassword = User::where('id', Auth::user()->id)
            ->update([
                'password'=>password_hash(request('p2'), PASSWORD_DEFAULT)
            ]);

            return redirect()->back()->with(['notif'=>'<div class="alert alert-success">Password berhasil diubah</div>']);
        } else {
            return redirect()->back()->withErrors(['password'=>'Password lama salah'])->withInput();
        }


        return redirect()->back();
    }


}
