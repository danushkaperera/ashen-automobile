<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    public const CACHE_KEY = 'site_settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return SiteSetting::query()->pluck('value', 'key')->all();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->all()[$key] ?? $default;

        if ($value === '1' || $value === '0') {
            $type = SiteSetting::query()->where('key', $key)->value('type');
            if ($type === 'boolean') {
                return $value === '1';
            }
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
    }
}
