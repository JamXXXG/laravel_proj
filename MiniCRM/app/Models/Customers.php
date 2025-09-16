<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    /** @use HasFactory<\Database\Factories\CustomersFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     *
     */
    protected $fillable = [
        'users_id',
        'name',
        'email',
        'phone',
        'notes',
        'avatar_path',
    ];

    public function deals(): HasOne
    {
        // return $this->hasMany(Deal::class, 'customers_id');
        // return $this->morphOne(Deal::class, 'dealInfo');
        return $this->hasOne(Deal::class, 'customers_id')->withTrashed();
    }
    public function user(): HasOne
    {
        // return $this->belongsTo(User::class, 'users_id');
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    // public function deals(): MorphMany
    // {
    //     return $this->morphMany(Deal::class, 'dealable')->withTrashed();
    // }
}
