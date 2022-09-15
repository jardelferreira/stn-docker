<?php

namespace App\Observers;

use App\Models\Base;
use App\Models\Project;
use Illuminate\Support\Str;

class BaseObserver
{

    public function creating(Base $base)
    {
        $project = Project::where("id",$base->project_id)->first();

        $base->name = Str::upper("{$base->name}-{$project->initials}");
        $base->uuid = Str::uuid();
        // $base->slug = Str::slug($base->name);

    }

    public function updating(Base $base)
    {
        $project = Project::where("id",$base->project_id)->first();

        $base->name = Str::upper("{$base->name}-{$project->initials}");
        // $base->slug = Str::slug($base->name);
        $base->uuid = Str::uuid();

    }

    /**
     * Handle the Base "created" event.
     *
     * @param  \App\Models\Base  $base
     * @return void
     */
    public function created(Base $base)
    {
        //
    }

    /**
     * Handle the Base "updated" event.
     *
     * @param  \App\Models\Base  $base
     * @return void
     */
    public function updated(Base $base)
    {
        //
    }

    /**
     * Handle the Base "deleted" event.
     *
     * @param  \App\Models\Base  $base
     * @return void
     */
    public function deleted(Base $base)
    {
        //
    }

    /**
     * Handle the Base "restored" event.
     *
     * @param  \App\Models\Base  $base
     * @return void
     */
    public function restored(Base $base)
    {
        //
    }

    /**
     * Handle the Base "force deleted" event.
     *
     * @param  \App\Models\Base  $base
     * @return void
     */
    public function forceDeleted(Base $base)
    {
        //
    }
}
