<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingGroup extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'num_participants',
        'contribution_amount',
        'current_round',
        'status',
    ];

    protected $casts = [
        'contribution_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(SavingGroupParticipant::class);
    }

    public function getMonthlyPoolAttribute(): float
    {
        return round($this->num_participants * $this->contribution_amount, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
