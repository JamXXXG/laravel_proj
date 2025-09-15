<?php

namespace App\Jobs;

use App\Models\Deal;
use App\Notifications\DealWonNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotification implements ShouldQueue
{
    use Queueable;

    public $deal;

    /**
     * Create a new job instance.
     */
    public function __construct(Deal $deal)
    {
        //
        $this->deal = $deal;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       if ($this->deal->deal_status_id == "4") {
            if (!$this->deal->won_at) {
                $this->deal->forceFill(['won_at' => now()])->save();
            }
            $this->deal->user->notify(new DealWonNotification($this->deal));
        }
    }
}
