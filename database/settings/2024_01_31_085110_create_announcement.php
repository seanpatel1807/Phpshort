<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('announcements.user', 'content');
        $this->migrator->add('announcements.user_color', 'primary');
        $this->migrator->add('announcements.guest', 'content');
        $this->migrator->add('announcements.guest_color', 'primary');
    }
};
?>
