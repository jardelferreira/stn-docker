<?php

namespace App\Observers;

use App\Models\Receipt;
use Illuminate\Support\Facades\URL;

class ReceiptObserver
{

    public function creating(Receipt $receipt)
    {
        $receipt->local = $receipt->local ?? "{$receipt->branch->cidade}-{$receipt->branch->uf}";
        $receipt->link = "";
    }
    /**
     * Handle the Receipt "created" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function created(Receipt $receipt)
    {
        $receipt->link = URL::signedRoute('extern.receiptShow',['receipt' => $receipt->id],null,false);
        $receipt->save();
    }

    /**
     * Handle the Receipt "updated" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function updated(Receipt $receipt)
    {
        //
    }

    /**
     * Handle the Receipt "deleted" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function deleted(Receipt $receipt)
    {
        //
    }

    /**
     * Handle the Receipt "restored" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function restored(Receipt $receipt)
    {
        //
    }

    /**
     * Handle the Receipt "force deleted" event.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return void
     */
    public function forceDeleted(Receipt $receipt)
    {
        //
    }
}
