<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'notes',
        'visit_count',
        'first_visited_at',
        'last_visited_at',
    ];

    protected $casts = [
        'first_visited_at' => 'datetime',
        'last_visited_at' => 'datetime',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(CustomerVisit::class)->latest('visited_at');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(WorkshopJob::class)->latest();
    }

    public function isRegular(): bool
    {
        return (int) $this->visit_count >= 2;
    }

    public function customerType(): string
    {
        return $this->isRegular() ? 'regular' : 'new';
    }

    public function customerTypeLabel(): string
    {
        return $this->isRegular() ? 'Regular customer' : 'New customer';
    }

    public function scopeRegular(Builder $query): Builder
    {
        return $query->where('visit_count', '>=', 2);
    }

    public function scopeNewCustomers(Builder $query): Builder
    {
        return $query->where('visit_count', '<', 2);
    }

    public static function normalizePhone(?string $phone): ?string
    {
        if ($phone === null || trim($phone) === '') {
            return null;
        }

        return preg_replace('/\s+/', '', $phone);
    }

    public static function findByContact(?string $phone = null, ?string $email = null): ?self
    {
        $phone = self::normalizePhone($phone);
        $email = $email ? strtolower(trim($email)) : null;

        if ($phone) {
            $match = static::query()->where('phone', $phone)->first();
            if ($match) {
                return $match;
            }
        }

        if ($email) {
            return static::query()->where('email', $email)->first();
        }

        return null;
    }

    public function recordVisit(): void
    {
        $count = $this->visits()->count();
        $this->forceFill([
            'visit_count' => $count,
            'first_visited_at' => $this->first_visited_at ?: now(),
            'last_visited_at' => now(),
        ])->save();
    }
}
