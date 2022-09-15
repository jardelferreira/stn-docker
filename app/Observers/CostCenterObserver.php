<?php

namespace App\Observers;

use App\Models\CostCenter;
use Illuminate\Support\Str;

class CostCenterObserver
{
    /**
     * Handle the CostCenter "created" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function creating(CostCenter $costCenter)
    {
        $costCenter->uuid = Str::uuid();
    }
    /**
     * Handle the CostCenter "created" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function created(CostCenter $costCenter)
    {
        //
    }

    /**
     * Handle the CostCenter "updated" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function updated(CostCenter $costCenter)
    {
        //
    }

    /**
     * Handle the CostCenter "deleted" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function deleted(CostCenter $costCenter)
    {
        //
    }

    /**
     * Handle the CostCenter "restored" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function restored(CostCenter $costCenter)
    {
        //
    }

    /**
     * Handle the CostCenter "force deleted" event.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return void
     */
    public function forceDeleted(CostCenter $costCenter)
    {
        //
    }
}
