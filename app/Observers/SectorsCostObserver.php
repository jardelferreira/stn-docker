<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\sectorsCosts;

class SectorsCostObserver
{
    /**
     * Handle the sectorsCosts "created" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function creating(sectorsCosts $sectorsCosts)
    {
        $sectorsCosts->project_id = $sectorsCosts->cost->project->id;
        $sectorsCosts->name = Str::upper($sectorsCosts->name);
        $sectorsCosts->slug = Str::random(10);
        $sectorsCosts->uuid = Str::uuid();
    }

    /**
     * Handle the sectorsCosts "created" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function created(sectorsCosts $sectorsCosts)
    {
        //
    }

    /**
     * Handle the sectorsCosts "updated" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function updated(sectorsCosts $sectorsCosts)
    {
        //
    }

    /**
     * Handle the sectorsCosts "deleted" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function deleted(sectorsCosts $sectorsCosts)
    {
        //
    }

    /**
     * Handle the sectorsCosts "restored" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function restored(sectorsCosts $sectorsCosts)
    {
        //
    }

    /**
     * Handle the sectorsCosts "force deleted" event.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return void
     */
    public function forceDeleted(sectorsCosts $sectorsCosts)
    {
        //
    }
}
