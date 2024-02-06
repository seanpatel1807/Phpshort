<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class socialSetting extends Settings
{
    public string $facebook;
    public string $instagram;
    public string $twitter;
    public string $youtube;


    public static function group(): string 
    {
        return 'social';
    }
}
