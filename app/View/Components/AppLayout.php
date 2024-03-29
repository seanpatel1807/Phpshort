<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Setting;


class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $settings = Setting::all();
        $groupedSettings = $settings->groupBy('group');
        $theme = $settings->where('name', 'theme')->first(); // Assuming 'theme' is the name for the theme setting
        $logo = $settings->where('name', 'logo')->first(); // Assuming 'logo' is the name for the logo setting
        $user_content = $settings->where('name', 'user')->first(); // Assuming 'theme' is the name for the theme setting
        $user_color = $settings->where('name', 'user_color')->first();
        
        return view('layouts.app',compact('groupedSettings'));
    }
}
