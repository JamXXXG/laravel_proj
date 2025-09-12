<?php

namespace App\Models;

use App\Notifications\DealWonNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    /** @use HasFactory<\Database\Factories\DealFactory> */
    use HasFactory, SoftDeletes;

      /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     *
     */
    protected $fillable = [
        'users_id',
        'customers_id',
        'deal_status_id',
        'title',
        'amount',
        'expected_close_at',
        'won_at',
        'position',
    ];
    protected static function booted(): void
    {
        // If a deal is created already as 'won'
            static::created(function (Deal $deal) {
                if ($deal->deal_status_id == "4") {
                    if (!$deal->won_at) {
                        $deal->forceFill(['won_at' => now()])->save();
                    }
                    $deal->user->notify(new DealWonNotification($deal));
                }
            });

            // If a deal is updated as 'won'
        static::updated(function (Deal $deal) {
            if ($deal->deal_status_id == "4") {
                if (!$deal->won_at) {
                    $deal->forceFill(['won_at' => now()])->save();
                }
                $deal->user->notify(new DealWonNotification($deal));
            }
        });
    }


    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customers_id');
    }
    public function status()
    {
        return $this->belongsTo(DealStatus::class, 'deal_status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
