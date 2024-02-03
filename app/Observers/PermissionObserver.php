<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Permission;

class PermissionObserver
{

    public function creating(Permission $permission)
    {
        if (!$permission->slug) {
            $permission->slug = Str::slug($permission->name);
        }
    }


    public function updating(Permission $permission)
    {
        if (!$permission->slug) {
            $permission->slug = Str::slug($permission->name);
        }
    }

    /**
     * Handle the Permission "created" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function updated(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function deleted(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "restored" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function restored(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        //
    }
}
