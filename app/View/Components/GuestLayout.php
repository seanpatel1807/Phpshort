<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Setting;


class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $settings = Setting::all();
        $groupedSettings = $settings->groupBy('group');
        $guest_content = $settings->where('name', 'guest')->first(); // Assuming 'theme' is the name for the theme setting
        $guest_color = $settings->where('name', 'guest_color')->first();

        return view('layouts.guest',compact('groupedSettings'));    
    }
}
