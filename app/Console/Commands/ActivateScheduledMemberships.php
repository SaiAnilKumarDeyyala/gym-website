<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Membership;
use Carbon\Carbon;

class ActivateScheduledMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activate:scheduled-memberships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate scheduled memberships whose start_date is today or earlier.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today()->toDateString();

        $items = Membership::where('start_date', '<=', $today)
            ->where(function($q) {
                $q->whereNull('status')->orWhere('status', '!=', 'active');
            })->get();

        $count = 0;
        foreach ($items as $m) {
            $m->status = 'active';
            $m->save();
            $count++;
        }

        $this->info("Activated {$count} scheduled memberships.");

        return 0;
    }
}
