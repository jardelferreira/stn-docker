<?php

namespace App\Observers;

use App\Models\Cost;
use Illuminate\Support\Str;

class CostObserver
{
    /**
     * Handle the Cost "created" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function creating(Cost $costCenter)
    {
        $costCenter->uuid = Str::uuid();
    }
    /**
     * Handle the Cost "created" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function created(Cost $costCenter)
    {
        //
    }

    /**
     * Handle the Cost "updated" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function updated(Cost $costCenter)
    {
        //
    }

    /**
     * Handle the Cost "deleted" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function deleted(Cost $costCenter)
    {
        //
    }

    /**
     * Handle the Cost "restored" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function restored(Cost $costCenter)
    {
        //
    }

    /**
     * Handle the Cost "force deleted" event.
     *
     * @param  \App\Models\Cost  $costCenter
     * @return void
     */
    public function forceDeleted(Cost $costCenter)
    {
        //
    }
}
