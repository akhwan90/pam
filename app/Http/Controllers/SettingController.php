<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {

        $data['menuAktif'] = 'setting';
        $data['settings'] = Setting::get();

        return view('admin.setting.index', $data);
    }

    public function settingSave()
    {
        $settingName = request('name');
        $settingValue = request('value');

        $i = 0;
        foreach ($settingName as $set) {
            Setting::where('name', $set)
            ->update([
                'value'=>$settingValue[$i]
            ]);
            $i++;
        }

        return redirect('admin/setting')->with('notif', '<div class="alert alert-success">Perubahan disimpan</div>');
    }
}
