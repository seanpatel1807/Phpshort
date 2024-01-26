<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class IndexController extends Controller
{
    public function setting()
    {
        $settings = Setting::all();
        $groupedSettings = $settings->groupBy('group');

        return view('admin.setting', compact('groupedSettings'));
    }
}
