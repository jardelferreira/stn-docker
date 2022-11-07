<?php

namespace App\Observers;

use App\Models\Profession;
use Illuminate\Support\Str;

class ProfessionObserver
{
    /**
     * Handle the Profession "created" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function created(Profession $profession)
    {
        //
    }
    /**
     * Handle the Profession "created" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function creating(Profession $profession)
    {
        $profession->uuid = Str::uuid();
        $profession->salary = 1000.00;
        $profession->percent = 0.3;
        $profession->aditional = true;

    }

    /**
     * Handle the Profession "updated" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function updated(Profession $profession)
    {
        //
    }

    /**
     * Handle the Profession "updated" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function updating(Profession $profession)
    {
        
    }
    
    /**
     * Handle the Profession "deleted" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function deleted(Profession $profession)
    {
        //
    }

    /**
     * Handle the Profession "restored" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function restored(Profession $profession)
    {
        //
    }

    /**
     * Handle the Profession "force deleted" event.
     *
     * @param  \App\Models\Profession  $profession
     * @return void
     */
    public function forceDeleted(Profession $profession)
    {
        //
    }
}
