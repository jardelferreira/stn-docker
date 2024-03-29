<?php

use App\Models\Base;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Formlist;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Profession;
use App\Models\Project;
use App\Models\Provider;
use App\Models\Sector;
use App\Models\User;
use Yajra\Acl\Models\Permission;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SGLT',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SGLT</b> - STN',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => true,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /* 
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'Painel Publico',
            'route' => 'public.index',
            'icon' => 'fa fa-dashcube',
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'can' => User::resourcesPublicModel(),
        ],
        [
            'text' => 'Documentos',
            'route' => 'dashboard.documents',
            'icon' => 'fa fa-file-o',
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'can' => Document::resourcesModel()
        ],
        [
            'text' => 'DP',
            'icon' => 'fa fa-users',
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'can' => ['dp','admin'],
            'submenu' => [
                [
                    'text'  => 'Profissões',
                    'route' => 'dashboard.professions',
                    'can'   =>  Profession::resourcesModel()
                ],
                [
                    'text'  => 'Colaboradores',
                    'route' => 'dashboard.employees',
                    'can'   =>  Employee::resourcesModel()
                ],
            ]
        ],
        [
            'text'        => 'Financeiro',
            'icon'        => 'fa fa-bar-chart',
            'icon_color'  => 'primary',
            'classes'    => "bg-light",
            'can'   =>  ['financeiro','admin','suprimentos'],
            'submenu' => [
                [
                    'text' => 'Filiais',
                    'route' => 'dashboard.financeiro.branches',
                    'can'   => Branch::resourcesModel()
                ],
                [
                    'text' => 'Suprimentos',
                    'submenu'  => [
                        [
                            'text' => 'NFs',
                            'route' => 'dashboard.invoices.index',
                            'can' => Invoice::resourcesModel()
                        ],
                        [
                            'text' => 'Fornecedores',
                            'route'  => 'dashboard.providers.index',
                            'can' => Provider::resourcesModel()
                        ],
                        [
                            'text' => 'Categorias',
                            'route'  => 'dashboard.financeiro.categories',
                            'can'   => Category::resourcesModel()
                        ],
                        [
                            'text' => 'Produtos',
                            'route'  => 'dashboard.financeiro.products',
                            'can'   => Product::resourcesModel()
                        ],
                    ]
                ],
                [
                    'text' => 'Custos',
                    'can'   => Cost::resourcesModel(),
                    'submenu' => [
                        [
                            'text' => 'Centros de custo',
                            'route'  => 'dashboard.costs.index',
                            'can'   => Cost::resourcesModel(),
                        ],
                        [
                            'text' => 'Setores de custo',
                            'route'  => 'dashboard.costs_sectors.index',
                            'can'   => Cost::resourcesModel(),
                        ],
                        [
                            'text' => 'Departamentos de custo',
                            'route'  => 'dashboard.costs_departaments.index',
                            'can'   => Cost::resourcesModel(),
                        ],
                    ],
                ],
            ]
        ],
        // ['header' => 'account_settings'],
        [
            'text' => "Formulários",
            'icon' => "fa fa-id-card-o",
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'can' => Formlist::resourcesModel(),
            'submenu' => [
                [
                    'text' => "Fichas de materiais",
                    'route' => 'dashboard.formlists',
                    'icon' => "fa fa-id-card-o",
                    'can'   => Formlist::resourcesModel()
                ],
                [
                    'text' => 'Recibo de pagamentos',
                    'icon' => "fa fa-id-card-o",
                    'route' => 'dashboard.financeiro.receipts',
                    'can'   => Formlist::resourcesModel()
                ]
            ]
        ],
        [
            'text' => 'Controle de acesso',
            'icon' => 'fas fa-users-cog ',
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'can' => ['acl','admin'],
            'submenu' => [
                [
                    'text' => 'Usuários',
                    'route'  => 'dashboard.users',
                    'icon' => 'fas fa-fw fa-user',
                    'can'  => User::resourcesModel()
                ],
                [
                    'text' => 'Permissões',
                    'route'  => 'dashboard.permissions',
                    'icon' => 'fas fa-fw fa-user',
                    'can'  => Permission::resourcesModel()
                ],
                [
                    'text' => 'Funções',
                    'route'  => 'dashboard.roles',
                    'icon' => 'fas fa-fw fa-user',
                    'can'  => Permission::resourcesRolesModel()
                ],
                [
                    'text' => 'Biometria',
                    'route'  => 'dashboard.biometrics',
                    'icon' => 'fa fa-user-circle-o',
                    'can'  => User::resourcesModel()
                ],
            ]
        ],
        [
            'text' => 'Projetos',
            'icon_color'  => 'primary',
            'classes' => "bg-light",
            'icon' => 'fas fa-project-diagram ',
            'can'  => Project::resourcesModel(),
            'submenu' => [
                [
                    'text' => 'Todos Projetos',
                    'route'  => 'dashboard.projects',
                    'can'   =>Project::resourcesModel()
                ],
                [
                    'text' => 'Bases',
                    'route'  => 'dashboard.bases.index',
                    'can'   => Base::resourcesModel()
                ],
                [
                    'text' => 'Setores',
                    'route'  => 'dashboard.sectors.index',
                    'can'   => Sector::resourcesModel()
                ],
            ]
        ],
        // [
        //     'text' => 'change_password',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-lock',
        // ],
        // [
        //     'text'    => 'Controle de acesso',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //            [
        //             'text'    => 'Permissões',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'Gerenciar',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text' => 'Criar',
        //                     'url'  => '#',
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text'    => 'Funções',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'Gerenciar',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text' => 'Criar',
        //                     'url'  => '#',
        //                 ],
        //             ],
        //         ],
        //     ],
        // ],

        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
