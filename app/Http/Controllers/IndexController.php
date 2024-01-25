<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(GeneralSettings $settings){
        return view('index', [
            'tile' => $settings->tile,
        ]);
    }
}
