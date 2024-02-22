<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('advanced.bad_words', 'white');
        $this->migrator->add('advanced.user_agent','white');
        $this->migrator->add('advanced.proxies', 'light');
    }
};
