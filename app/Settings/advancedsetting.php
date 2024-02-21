<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class advancedsetting extends Settings
{
    public string $bad_words;
    public string $user_agents;
    public string $proxies;
    

    public static function group(): string
    {
        return 'advanced';
    }
}
