<?php

namespace App\Providers;

use App\Models\Base;
use App\Models\Cost;
use App\Models\DepartamentCost;
use App\Models\Formlist;
use App\Models\Invoice;
use App\Models\Profession;
use App\Models\Project;
use App\Models\Provider;
use App\Models\Sector;
use App\Models\sectorsCosts;
use App\Models\User;
use App\Observers\BaseObserver;
use App\Observers\CostObserver;
use App\Observers\DepartamentCostObserver;
use App\Observers\FormlistObserver;
use App\Observers\InvoiceObserver;
use Yajra\Acl\Models\Role;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Yajra\Acl\Models\Permission;
use App\Observers\PermissionObserver;
use App\Observers\ProfessionObserver;
use App\Observers\ProjectObserver;
use App\Observers\ProviderObserver;
use App\Observers\SectorObserver;
use App\Observers\SectorsCostObserver;
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
        Cost::observe(CostObserver::class);
        sectorsCosts::observe(SectorsCostObserver::class);
        DepartamentCost::observe(DepartamentCostObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Base::observe(BaseObserver::class);
        Sector::observe(SectorObserver::class);
        Profession::observe(ProfessionObserver::class);
        Formlist::observe(FormlistObserver::class);
    }
}
