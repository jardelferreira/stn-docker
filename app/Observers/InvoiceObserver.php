<?php

namespace App\Observers;

use App\Models\DepartamentCost;
use App\Models\Invoice;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvoiceObserver
{
    protected $request, $provider, $departament, $cascade_path, $path, $old_invoice;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function creating(Invoice $invoice)
    {

        $this->departament = DepartamentCost::where('id', $invoice->departament_cost_id)->first();
        $this->provider = Provider::where('id', $invoice->provider_id)->first();

        $invoice->cost_sector_id = $this->departament->cost_sector_id;
        $invoice->cost_center_id = $this->departament->cost_center_id;
        $invoice->project_id     = $this->departament->project_id;

        $invoice->name = "{$invoice->invoice_type}-{$invoice->number}-{$this->provider->fantasy_name}";

        $this->cascade_path = "project/{$this->departament->sectorCost->cost->project->slug}/cost/{$this->departament->sectorCost->cost->slug}/sector/{$this->departament->sectorCost->slug}/departament/{$this->departament->slug}/";

        $this->path = $this->request->file('file_invoice')->storeAs('public/files', "{$this->cascade_path}{$invoice->name}.pdf");

        $invoice->file_path = $this->path;
        $invoice->user_id = Auth::user()->id;
        $invoice->name = Str::upper($invoice->name);
        // $invoice->slug = Str::upper("{$invoice->invoice_type}-{$invoice->number}-{$this->provider->uuid}");
        $invoice->uuid = Str::uuid();
    }

    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updating(Invoice $invoice)
    {
        $this->departament = DepartamentCost::where('id', $invoice->departament_cost_id)->first();
        $this->provider = Provider::where('id', $invoice->provider_id)->first();
        // $this->cascade_path = "project/{$this->departament->sectorCost->cost->project->slug}/cost/{$this->departament->sectorCost->cost->slug}/sector/{$this->departament->sectorCost->slug}/departament/{$this->departament->slug}/";

        // $this->path = $this->request->file('file_invoice')->storeAs('public/files', "{$this->cascade_path}{$invoice->name}.pdf");
        // $invoice->file_path = $this->path;


        $invoice->cost_sector_id = $this->departament->cost_sector_id;
        $invoice->cost_center_id = $this->departament->cost_center_id;
        $invoice->project_id     = $this->departament->project_id;
        $invoice->user_id = Auth::user()->id;
        $invoice->name = Str::upper($invoice->name);
        // $invoice->slug = Str::upper("{$invoice->invoice_type}-{$invoice->number}-{$this->provider->uuid}");

    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        if (Storage::exists($invoice->file_path)) {
            Storage::delete($invoice->file_path);
            Session::flash('deleted_img', 'Arquivo excluído com sucesso!');
        } else {
            Session::flash('deleted_img', 'O arquivo pdf não foi localizado!');
        }
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
