<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Provider;
use App\Models\User;
use Yajra\Acl\Models\Role;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Yajra\Acl\Models\Permission;
use App\Observers\PermissionObserver;
use App\Observers\ProjectObserver;
use App\Observers\ProviderObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
        Project::observe(ProjectObserver::class);
        Provider::observe(ProviderObserver::class);
    }
}
