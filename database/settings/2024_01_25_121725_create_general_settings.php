<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.title', 'phpshort');
        $this->migrator->add('general.tagline', 'Smart and powerful short links');
        $this->migrator->add('general.custom_index', '1');
        $this->migrator->add('general.results_per_page', '10');
        $this->migrator->add('general.language', 'english');
        $this->migrator->add('general.timezone', 'UTC');
        $this->migrator->add('general.Custom_js', '<script>
        if(top != self){
            top.location.replace(document.location);
        }
        </script>');

    }
};
?>
