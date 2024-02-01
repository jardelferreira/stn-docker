<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\User;
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
        Permission::createResource($project->initials);
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        // if ($project->isDirty('initials')) {
        //     $users = (Permission::where("resource", Str::title($project->getRawOriginal('initials')))->first()
        //         ->join("permission_user", "permissions.id", "=", "permission_user.permission_id")
        //         ->select("permission_user.user_id")->distinct()->pluck("permission_user.user_id"));

        //     Permission::where('resource', Str::title($project->getOriginal('initials')))->delete();

        //     Permission::createResource($project->initials);

        //     User::whereIn("id", $users)->each(function ($user) use ($project) {
        //         $user->permissions->grantPermissionByResource(Str::title($project->initials));
        //     });
        // }
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
