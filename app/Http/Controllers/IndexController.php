<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class IndexController extends Controller
{        

    public function setting()
    {
        $settings = Setting::all();//setting ni badhi value aiya fetch thase 
        $groupedSettings = $settings->groupBy('group');
        return view('admin.setting', compact('groupedSettings'));
        
    }
    public function appearance()
    {
        $settings = Setting::all();//setting ni badhi value aiya fetch thase 
        $groupedSettings = $settings->groupBy('group');
        return view('admin.appearance', compact('groupedSettings'));        
    }
}
