<?php

namespace App\Observers;

use App\Models\Sector;
use App\Models\Stoks;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StokObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Stoks "created" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function created(Stoks $stoks)
    {
        //
    }
    /**
     * Handle the Stoks "created" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function creating(Stoks $stoks)
    {
        $sector = Sector::where('id',$this->request->sector)->first();

        $stoks->uuid = Str::uuid();
        $stoks->slug = Str::slug($stoks->invoiceProduct->name);

        $stoks->sector_id = $sector->id;
        $stoks->base_id = $sector->base_id;
        $stoks->project_id = $sector->project_id;
        $stoks->invoice_products_id = $this->request->id;
        $stoks->qtd = $this->request->qtd;
        $stoks->image_path = "teste.jpg";

    }

    /**
     * Handle the Stoks "updated" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function updated(Stoks $stoks)
    {
        //
    }

    /**
     * Handle the Stoks "deleted" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function deleted(Stoks $stoks)
    {
        //
    }

    /**
     * Handle the Stoks "restored" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function restored(Stoks $stoks)
    {
        //
    }

    /**
     * Handle the Stoks "force deleted" event.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return void
     */
    public function forceDeleted(Stoks $stoks)
    {
        //
    }
}
