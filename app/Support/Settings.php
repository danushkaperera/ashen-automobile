<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    public const CACHE_KEY = 'site_settings';

    public const TYPES_CACHE_KEY = 'site_setting_types';

    protected ?array $values = null;

    protected ?array $types = null;

    public function all(): array
    {
        return $this->values ??= Cache::rememberForever(self::CACHE_KEY, function () {
            return SiteSetting::query()->pluck('value', 'key')->all();
        });
    }

    protected function types(): array
    {
        return $this->types ??= Cache::rememberForever(self::TYPES_CACHE_KEY, function () {
            return SiteSetting::query()->pluck('type', 'key')->all();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->all()[$key] ?? $default;

        if (($value === '1' || $value === '0') && ($this->types()[$key] ?? null) === 'boolean') {
            return $value === '1';
        }

        return $value;
    }

    public function put(string $key, mixed $value, string $group = 'general', string $type = 'text'): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => is_bool($value) ? ($value ? '1' : '0') : $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        $this->flush();
    }

    public function putMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $key => $value) {
            $type = 'text';
            if (is_bool($value)) {
                $type = 'boolean';
            } elseif (str_contains($key, 'color')) {
                $type = 'color';
            }

            $this->put($key, $value, $group, $type);
        }
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::TYPES_CACHE_KEY);
        $this->values = null;
        $this->types = null;
    }
}
