<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerVisit extends Model
{
    public const GENERAL_SERVICE = 'general_service';
    public const OTHER_MAINTENANCE = 'other_maintenance';

    public const CATEGORIES = [
        self::GENERAL_SERVICE => 'General service',
        self::OTHER_MAINTENANCE => 'Other maintenance',
    ];

    protected $fillable = [
        'customer_id',
        'registered_by',
        'category',
        'service_id',
        'job_title',
        'notes',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function categoryLabel(): string
    {
        return $this->service?->title
            ?? $this->job_title
            ?? (self::CATEGORIES[$this->category] ?? $this->category);
    }
}
