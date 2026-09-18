<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkshopJob extends Model
{
    public const DRAFT = 'draft';
    public const INVOICED = 'invoiced';
    public const PAID = 'paid';

    protected $fillable = [
        'number',
        'invoice_number',
        'customer_id',
        'created_by',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'notes',
        'status',
        'gst_rate',
        'subtotal',
        'gst_amount',
        'total',
        'invoiced_at',
        'paid_at',
    ];

    protected $casts = [
        'gst_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'invoiced_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WorkshopJobItem::class, 'job_id')->orderBy('sort_order');
    }

    public function isDraft(): bool
    {
        return $this->status === self::DRAFT;
    }

    public function isInvoiced(): bool
    {
        return in_array($this->status, [self::INVOICED, self::PAID], true);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::PAID => 'Paid',
            self::INVOICED => 'Invoiced',
            default => 'Draft',
        };
    }

    public function recalculate(): void
    {
        $subtotal = (float) $this->items()->sum('line_total');
        $gst = round($subtotal * ((float) $this->gst_rate / 100), 2);

        $this->forceFill([
            'subtotal' => $subtotal,
            'gst_amount' => $gst,
            'total' => $subtotal + $gst,
        ])->save();
    }

    public static function nextNumber(string $prefix): string
    {
        $column = $prefix === 'INV-' ? 'invoice_number' : 'number';
        $latest = static::query()
            ->whereNotNull($column)
            ->where($column, 'like', $prefix.'%')
            ->orderByDesc('id')
            ->value($column);

        $next = $latest ? ((int) preg_replace('/\D/', '', (string) $latest)) + 1 : 1;

        return $prefix.str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    public function vehicleLabel(): string
    {
        return trim(implode(' ', array_filter([
            $this->vehicle_make,
            $this->vehicle_model,
            $this->vehicle_year,
        ]))) ?: '—';
    }
}
