<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Validation\Rule;

class IndexController extends Controller
{        

    public function setting()
    {
        $settings = Setting::all();//setting ni badhi value aiya fetch thase 
        $groupedSettings = $settings->groupBy('group');
        return view('admin.setting', compact('groupedSettings'));
        
    }
    public function updateSettings(Request $request)
    {    $data=$request->all();
    
    

    foreach ($data as $key => $value) {
        Setting::where('name', $key)->update(['payload' => $value]);
    }
    return redirect()->route('admin.setting');
    }


    public function appearance()
    {
        $settings = Setting::all();//setting ni badhi value aiya fetch thase 
        $groupedSettings = $settings->groupBy('group');
        return view('admin.appearance', compact('groupedSettings'));        
    }

    public function updateappearance(Request $request)
    {    
        $data=$request->all();
    foreach ($data as $key => $value) {
        Setting::where('name', $key)->update(['payload' => $value]);
    }

    return redirect()->route('admin.appearance');
    }
}
