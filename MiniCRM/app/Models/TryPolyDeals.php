<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TryPolyDeals extends Model
{
    /** @use HasFactory<\Database\Factories\TryPolyDealsFactory> */
    use HasFactory;

    protected $fillable = [
        'users_id',
        'dealable_id',
        'dealable_type',
        'deal_status_id',
        'title',
        'amount',
        'expected_close_at',
        'won_at',
        'position',
    ];

    public function dealable(): MorphTo
    {
        return $this->morphTo();
    } 
    public function status(): BelongsTo
    {
        return $this->belongsTo(DealStatus::class, 'deal_status_id');
        // return $this->hasOne(DealStatus::class, 'id', 'deal_status_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
        // return $this->hasOne(User::class, 'id', 'users_id');
    }
}
