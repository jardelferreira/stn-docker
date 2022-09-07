<?php

namespace App\Observers;

use App\Models\Provider;
use Illuminate\Support\Str;

class ProviderObserver
{
    public function creating(Provider $provider)
    {
        $provider->corporate_name = Str::upper($provider->corporate_name);
        $provider->fantasy_name = Str::upper($provider->fantasy_name);
        $provider->slug = Str::slug(Str::upper($provider->corporate_name) . " " . $provider->cnpj);
        $provider->uuid = Str::uuid();

    }


    public function updating(Provider $provider)
    {
        $provider->name = Str::upper($provider->name);
        $provider->slug = Str::slug($provider->name, '-');
    }

    /**
     * Handle the Provider "created" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function created(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "updated" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function updated(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "deleted" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function deleted(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "restored" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function restored(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "force deleted" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function forceDeleted(Provider $provider)
    {
        //
    }
}
