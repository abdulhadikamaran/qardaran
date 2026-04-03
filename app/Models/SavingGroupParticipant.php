<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingGroupParticipant extends Model
{
    protected $fillable = [
        'saving_group_id',
        'name',
        'has_won',
        'won_round',
    ];

    protected $casts = [
        'has_won' => 'boolean',
    ];

    public function savingGroup(): BelongsTo
    {
        return $this->belongsTo(SavingGroup::class);
    }
}
