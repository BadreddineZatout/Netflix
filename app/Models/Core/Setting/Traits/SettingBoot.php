<?php


namespace App\Models\Core\Setting\Traits;


trait SettingBoot
{
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::saved(function ($setting) {
            if ($setting->context === 'app') {
                cache()->forget('app-settings-global');
            }

            cache()->forget('app-delivery-settings');

            cache()->forget($setting->context.'_settings_cached');
        });

        static::updated(function ($setting) {
            if ($setting->context === 'app') {
                cache()->forget('app-settings-global');
            }

            cache()->forget('app-delivery-settings');

            cache()->forget($setting->context.'_settings_cached');
        });
    }
}
