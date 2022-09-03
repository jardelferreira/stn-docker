<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Permission;


class ProjectObserver
{
    public $old_project;

    public function __construct(Project $project)
    {
        $this->old_project = $project;
    }

    public function creating(Project $project)
    {
        $project->slug = Str::slug($project->name, '-');
    }


    public function updating(Project $project)
    {
        $project->slug = Str::slug($project->name, '-');
    }

    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $basic_permissions = ['read', 'view', 'maneger'];

        foreach ($basic_permissions as $value) {
            Permission::create([
                'name' => "{$project->initials}-{$value}",
                'slug' => Str::slug($project->name, '-')
            ]);
        }
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $basic_permissions = ['read', 'view', 'maneger'];

        foreach ($basic_permissions as $value) {
            $permission = Permission::where('name', "{$this->old_project->initials}-{$value}")->first();
            $permission->update([
                'name' => $project->name,
                'slug' => Str::slug($project->name, '-')
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        $basic_permissions = ['read', 'view', 'maneger'];

        foreach ($basic_permissions as $value) {
            $permission = Permission::where('name', "{$this->old_project->initials}-{$value}")->first();
            $permission->delete();
            Permission::create([
                'name' => "{$project->initials}-{$value}",
                'slug' => Str::slug($project->name, '-')
            ]);
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
