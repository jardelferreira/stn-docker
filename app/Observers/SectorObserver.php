<?php

namespace App\Observers;

use App\Models\Base;
use App\Models\Sector;
use Illuminate\Support\Str;

class SectorObserver
{
    
    public function creating(Sector $sector)
    {
        $base = Base::where("id",$sector->base_id)->first();
        
        $sector->uuid = Str::uuid();
        $sector->name = Str::upper($sector->name);
        $sector->project_id = $base->project_id;
    }

    public function updating(Sector $sector)
    {
        $base = Base::where("id",$sector->base_id)->first();

        $sector->name = Str::upper($sector->name);
        $sector->project_id = $base->project_id;
    }

    /**
     * Handle the Sector "created" event.
     *
     * @param  \App\Models\Sector  $sector
     * @return void
     */
    public function created(Sector $sector)
    {
        //
    }

    /**
     * Handle the Sector "updated" event.
     *
     * @param  \App\Models\Sector  $sector
     * @return void
     */
    public function updated(Sector $sector)
    {
        //
    }

    /**
     * Handle the Sector "deleted" event.
     *
     * @param  \App\Models\Sector  $sector
     * @return void
     */
    public function deleted(Sector $sector)
    {
        //
    }

    /**
     * Handle the Sector "restored" event.
     *
     * @param  \App\Models\Sector  $sector
     * @return void
     */
    public function restored(Sector $sector)
    {
        //
    }

    /**
     * Handle the Sector "force deleted" event.
     *
     * @param  \App\Models\Sector  $sector
     * @return void
     */
    public function forceDeleted(Sector $sector)
    {
        //
    }
}
