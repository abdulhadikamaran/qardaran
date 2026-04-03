<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'interest',
        'total_due',
        'amount_paid',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest' => 'decimal:2',
        'total_due' => 'decimal:2',
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
        return round($this->total_due - $this->amount_paid, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
