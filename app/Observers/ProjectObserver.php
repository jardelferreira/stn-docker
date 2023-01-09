<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Permission;


class ProjectObserver
{
    public $old_project;

    public function __construct(Request $request)
    {
      
    }

    public function creating(Project $project)
    {
        
        $project->name = Str::upper($project->name);
        $project->slug = Str::random(10);
        $project->uuid = Str::uuid();

    }


    public function updating(Project $project)
    {
        $project->name = Str::upper($project->name);
        
    }

    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {

    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {

    }
    
    public function deleting(Project $project)
    {
        $basic_permissions = ['read', 'view', 'maneger'];

        foreach ($basic_permissions as $value) {
            $permission = Permission::where('name', "{$project->initials}-{$value}")->first();
            if (is_object($permission)) {
                $permission->delete();
                
            }

        }
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }
}
