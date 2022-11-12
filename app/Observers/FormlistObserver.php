<?php

namespace App\Observers;

use App\Models\Formlist;

class FormlistObserver
{
    /**
     * Handle the Formlist "created" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function created(Formlist $formlist)
    {
        //
    }

    /**
     * Handle the Formlist "updated" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function updated(Formlist $formlist)
    {
        //
    }
    /**
     * Handle the Formlist "updated" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function updating(Formlist $formlist)
    {
        $rev = intval($formlist->revision) + 1;
        $formlist->revision = "0{$rev}";
    }

    /**
     * Handle the Formlist "deleted" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function deleted(Formlist $formlist)
    {
        //
    }

    /**
     * Handle the Formlist "restored" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function restored(Formlist $formlist)
    {
        //
    }

    /**
     * Handle the Formlist "force deleted" event.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return void
     */
    public function forceDeleted(Formlist $formlist)
    {
        //
    }
}
