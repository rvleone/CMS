<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(){
        $settings = [];
        $dbsettings = Setting::all();
        foreach ($dbsettings as $dbsetting) {
            $settings[$dbsetting['name']] = $dbsetting['content'];
        }
        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function save(Request $request){
        $data = $request->only([
            'title','subtitle', 'email', 'bgcolor', 'textcolor'
        ]);
        print_r($data);
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('settings')->withErrors($validator);
        }
        foreach($data as $item => $value){
            Setting::where('name', $item)->update(['content' => $value]);
        }
        return redirect()->route('settings')->with('warning', 'Configurações alteradas com sucesso');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'title' => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email' => ['string', 'email'],
            'bgcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/'],
            'textcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/'],
        ]);
    }
}
