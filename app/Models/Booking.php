<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'vehicle_make', 'vehicle_model', 'vehicle_year',
        'service_id', 'preferred_date', 'preferred_time', 'message', 'status', 'admin_notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
