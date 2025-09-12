<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealStatus extends Model
{
    public function deals()
    {
        return $this->hasMany(Deal::class, 'deal_status_id');
    }
}
