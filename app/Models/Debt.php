<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Debt extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'amount_paid',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getRemainingAttribute(): float
    {
        return round($this->amount - $this->amount_paid, 2);
    }

    public function scopeCurrent($query)
    {
        return $query->where('status', 'current');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
