<?php

namespace App\Observers;

use App\Models\InvoiceProducts;
use Illuminate\Support\Str;

class InvoiceProductsObserver
{
    public function creating(InvoiceProducts $invoiceProducts)
    {
        
    }
    /**
     * Handle the InvoiceProducts "created" event.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return void
     */
    public function created(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Handle the InvoiceProducts "updated" event.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return void
     */
    public function updated(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Handle the InvoiceProducts "deleted" event.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return void
     */
    public function deleted(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Handle the InvoiceProducts "restored" event.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return void
     */
    public function restored(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Handle the InvoiceProducts "force deleted" event.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return void
     */
    public function forceDeleted(InvoiceProducts $invoiceProducts)
    {
        //
    }
}
