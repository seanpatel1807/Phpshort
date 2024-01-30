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

        foreach ($data as $key => $value) 
            {
                Setting::where('name', $key)->update(['payload' =>$value]);
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
       
        foreach ($data as $key => $value) 
        {
            if (in_array($key, ['logo', 'favicon'])) 
            {
                $validationRules = [
                    $key => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
                ];
        
                $validator = validator($request->only($key), $validationRules);
        
                if ($validator->fails()) 
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
        
                $image = $request->file($key);
                $imageName = time() . '_' . $key . '.' . $image->extension();
                $image->move(public_path('images'), $imageName);
        
                Setting::where('name', $key)->update(['payload' => $imageName]);
            } 
            else 
            {
                Setting::where('name', $key)->update(['payload' => $value]);
            }
        }
        return redirect()->route('admin.appearance');
    }
}
