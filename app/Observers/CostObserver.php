<?php

namespace App\Observers;

use App\Models\Cost;
use Illuminate\Support\Str;

class CostObserver
{
    /**
     * Handle the Cost "created" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function creating(Cost $cost)
    {
        $cost->name = Str::upper($cost->name);
        $cost->slug = Str::random(10);
        $cost->uuid = Str::uuid();
    }
    /**
     * Handle the Cost "created" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function created(Cost $cost)
    {
        //
    }

    /**
     * Handle the Cost "updated" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function updating(Cost $cost)
    {
        $cost->name = Str::upper($cost->name);

    }
    /**
     * Handle the Cost "updated" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function updated(Cost $cost)
    {
        //
    }

    /**
     * Handle the Cost "deleted" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function deleted(Cost $cost)
    {
        //
    }

    /**
     * Handle the Cost "restored" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function restored(Cost $cost)
    {
        //
    }

    /**
     * Handle the Cost "force deleted" event.
     *
     * @param  \App\Models\Cost  $cost
     * @return void
     */
    public function forceDeleted(Cost $cost)
    {
        //
    }
}
