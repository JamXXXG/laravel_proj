<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DealStatus extends Model
{
    // public function deals(): BelongsTo
    // {
    //     // return $this->hasMany(Deal::class, 'deal_status_id');
    //     // return $this->morphOne(Deal::class, 'dealInfo');
    //     return $this->belongsTo(Deal::class, 'deal_status_id');
    // }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function deal()
    {
        return $this->morphOne(Deal::class, 'dealable');
    }

    // public function deals(): MorphMany
    // {
    //     return $this->morphMany(Deal::class, 'dealable')->withTrashed();
    // }
}
