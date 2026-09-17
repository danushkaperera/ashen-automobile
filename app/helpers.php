<?php

use App\Support\Settings;
use Illuminate\Support\Facades\Storage;

if (! function_exists('setting')) {
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $settings = app(Settings::class);

        if ($key === null) {
            return $settings->all();
        }

        return $settings->get($key, $default);
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (! $path) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('section')) {
    function section(string $key): ?\App\Models\HomepageSection
    {
        return \App\Models\HomepageSection::query()->where('key', $key)->first();
    }
}
