<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class generalSetting extends Settings
{
    public string $logo;
    public string $favicon;
    public string $theme;
    public string $custom_css;


    public static function group(): string
    {
        return 'appearance';
    }
}