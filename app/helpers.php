<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        // استخدم تخزين الملفات للذاكرة المؤقتة الخاص بكل tenant
        $tenantId = tenant('id') ?? 'central';
        $cacheKey = "{$tenantId}_setting_{$key}";

        return Cache::store('file')->rememberForever($cacheKey, function () use ($key, $default) {
            return Setting::where('key', $key)->value('value') ?? $default;
        });
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value) {
        // استخدم تخزين الملفات للذاكرة المؤقتة الخاص بكل tenant
        $tenantId = tenant('id') ?? 'central';
        $cacheKey = "{$tenantId}_setting_{$key}";

        Cache::store('file')->forget($cacheKey);
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}


