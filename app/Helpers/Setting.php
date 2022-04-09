<?php

use App\Settings\SettingService;

/**
 * Helper to access system settings.
 *
 * @return mixed|SettingService
 */
function setting(string $key = null, $default = null)
{
    $settingService = resolve(SettingService::class);

    if (is_null($key)) {
        return $settingService;
    }

    return $settingService->get($key, $default);
}
