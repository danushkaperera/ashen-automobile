<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = [
        'day_of_week', 'day_name', 'open_time', 'close_time', 'is_closed', 'sort_order',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function display(): string
    {
        if ($this->is_closed) {
            return 'Closed';
        }

        if (($this->open_time === '00:00' && $this->close_time === '24:00') || strcasecmp((string) $this->open_time, 'Open 24 hours') === 0) {
            return 'Open 24 hours';
        }

        return trim(($this->open_time ?? '') . ' – ' . ($this->close_time ?? ''));
    }
}
