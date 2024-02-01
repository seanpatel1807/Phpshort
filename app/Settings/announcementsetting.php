<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class announcementSetting extends Settings
{
    public string $user;
    public string $user_color;
    public string $guest;
    public string $guest_color;


    public static function group(): string 
    {
        return 'announcement';
    }
}