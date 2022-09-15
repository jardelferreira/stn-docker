<?php

namespace App\Observers;

use App\Models\DepartamentCost;
use App\Models\sectorsCosts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartamentCostObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Handle the DepartamentCost "created" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function creating(DepartamentCost $departamentCost)
    {
        $sector = sectorsCosts::where("id",$departamentCost->cost_sector_id)->first();
     
        $departamentCost->name = Str::upper($departamentCost->name);
        $departamentCost->slug = Str::slug($departamentCost->name);
        $departamentCost->uuid = Str::uuid();
        $departamentCost->cost_center_id = $sector->cost->id;
        $departamentCost->project_id = $sector->cost->project->id;
    }

    public function updating(DepartamentCost $departamentCost)
    {
        $sector = sectorsCosts::where("id",$departamentCost->cost_sector_id)->first();
        
        $departamentCost->name = Str::upper($departamentCost->name);
        $departamentCost->slug = Str::slug($departamentCost->name);
        $departamentCost->cost_center_id = $sector->cost_center_id;
        $departamentCost->cost_sector_id = $sector->id;
        $departamentCost->project_id = $sector->project_id;
    }

    /**
     * Handle the DepartamentCost "created" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function created(DepartamentCost $departamentCost)
    {
        //
    }


    /**
     * Handle the DepartamentCost "updated" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function updated(DepartamentCost $departamentCost)
    {
        //
    }

    /**
     * Handle the DepartamentCost "deleted" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function deleted(DepartamentCost $departamentCost)
    {
        //
    }

    /**
     * Handle the DepartamentCost "restored" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function restored(DepartamentCost $departamentCost)
    {
        //
    }

    /**
     * Handle the DepartamentCost "force deleted" event.
     *
     * @param  \App\Models\DepartamentCost  $departamentCost
     * @return void
     */
    public function forceDeleted(DepartamentCost $departamentCost)
    {
        //
    }
}
