<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Validation\Rule;

class IndexController extends Controller
{        

    private function updateSettingsGroup(Request $request, $route)
    {
        $data = $request->all();

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
        return redirect()->route($route);
    }

    public function general()
    {
        $groupedSettings = $this->getGroupedSettings();
        return view('admin.general', compact('groupedSettings'));
    }

    public function updateGeneral(Request $request)
    {
        return $this->updateSettingsGroup($request, 'admin.general');
    }
    
    public function social()
    {
        $groupedSettings = $this->getGroupedSettings();
        return view('admin.social', compact('groupedSettings'));
    }

    public function updatesocial(Request $request)
    {
        return $this->updateSettingsGroup($request, 'admin.social');
    }

    public function announcement()
    {
        $groupedSettings = $this->getGroupedSettings();
        return view('admin.announcement', compact('groupedSettings'));
    }

    public function updateannouncement(Request $request)
    {
        return $this->updateSettingsGroup($request, 'admin.announcement');
    }

    public function appearance()
    {
        $groupedSettings = $this->getGroupedSettings();//call the function which contains the main function
        return view('admin.appearance', compact('groupedSettings'));        
    }

    public function updateappearance(Request $request)
    {    
        return $this->updateSettingsGroup($request, 'admin.appearance');
    }
    public function advanced()
    {
        $groupedSettings = $this->getGroupedSettings();//call the function which contains the main function
        return view('admin.advanced', compact('groupedSettings'));        
    }

    public function updateadvanced(Request $request)
    {    
        return $this->updateSettingsGroup($request, 'admin.advanced');
    }


    private function getGroupedSettings()//just made a function which contains all the common functionalities 
    {
        $settings = Setting::all();
        return $settings->groupBy('group');
    }
}
?>
