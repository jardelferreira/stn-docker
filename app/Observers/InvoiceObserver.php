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
    protected $request, $provider, $departament, $cascade_path, $path;

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
       
        $this->departament = DepartamentCost::where('id',$invoice->departament_cost_id)->first();
        $this->provider = Provider::where('id',$invoice->provider_id)->first();

        $invoice->cost_sector_id = $this->departament->cost_sector_id;
        $invoice->cost_center_id = $this->departament->cost_center_id;
        $invoice->project_id     = $this->departament->project_id;

        $invoice->name = "{$invoice->invoice_type}-{$invoice->number}-{$this->provider->fantasy_name}";

        $this->cascade_path = "{$this->departament->sectorCost->cost->project->initials}/{$this->departament->sectorCost->cost->name}/{$this->departament->sectorCost->name}/{$this->departament->name}/";

        $this->path = $this->request->file('file_invoice')->storeAs('public/files',"{$this->cascade_path}{$invoice->name}.pdf");

        $invoice->file_path = $this->path;
        $invoice->user_id = Auth::user()->id;
        $invoice->name = Str::upper($invoice->name);
        $invoice->slug = Str::upper($invoice->name);
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
        $this->departament = DepartamentCost::where('id',$invoice->departament_cost_id)->first();
        $this->provider = Provider::where('id',$invoice->provider_id)->first();

        $invoice->name = "{$invoice->invoice_type}-{$invoice->number}-{$this->provider->fantasy_name}";
        
        $this->cascade_path = "{$this->departament->sectorCost->cost->project->initials}/{$this->departament->sectorCost->cost->name}/{$this->departament->sectorCost->name}/{$this->departament->name}/";
        if ($this->request->file('file_invoice')) {
            
            $this->path = $this->request->file('file_invoice')->storeAs('public/files',"{$this->cascade_path}{$invoice->name}.pdf");
            $invoice->file_path = $this->path;
        }
        
        $invoice->cost_sector_id = $this->departament->cost_sector_id;
        $invoice->cost_center_id = $this->departament->cost_center_id;
        $invoice->project_id     = $this->departament->project_id;
        $invoice->user_id = Auth::user()->id;
        $invoice->name = Str::upper($invoice->name);
        $invoice->slug = Str::upper($invoice->name);
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
            Session::flash('deleted_img','Arquivo excluído com sucesso!');
        }else{
            Session::flash('deleted_img','O arquivo pdf não foi localizado!');
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
