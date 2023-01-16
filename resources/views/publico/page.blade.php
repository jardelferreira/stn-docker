<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Custom Meta Tags --}}
    @yield('meta_tags')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    @yield('css')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'SGLT'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{-- Body Content --}}
        @yield('body')
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-1 text-light fs-4 fw-bold border-bottom">
                <p><small>STN Empreendimentos</small></p>
            </div>
            <div class="list-group list-group-flush my-1">

                <a href="{{ route('public.index') }}"
                    class="list-group-item list-group-item-action border-bottom py-1 mb-1">
                    <i class="fas fa-warehouse    "></i>
                    Home</a>
                @can('dashboard')
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action border-bottom py-1 mb-1"><i
                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                @endcan
                @can('public-projects')
                    
                <a href="{{ route('public.projects') }}"
                class="list-group-item list-group-item-action border-bottom py-1 mb-1"><i
                class="fas fa-tachometer-alt me-2"></i>Projetos</a>
                @endcan
                <a href="{{ route('public.employees.formlists', Auth::id()) }}"
                    class="list-group-item list-group-item-action border-bottom py-1 mb-1">
                    <i class="fas fa-id-card me-2"></i>Minhas Fichas</a>
                @yield('sidebar-list')
                {{-- 
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-project-diagram me-2"></i>Projects</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-chart-line me-2"></i>Analytics</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-paperclip me-2"></i>Reports</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-shopping-cart me-2"></i>Store Mng</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-gift me-2"></i>Products</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-comment-dots me-2"></i>Chat</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-light fw-bold"><i
                            class="fas fa-map-marker-alt me-2"></i>Outlet</a></small>
                <small><a href="#"
                        class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                            class="fas fa-power-off me-2"></i>Logout</a></small> --}}
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3 " id="menu-toggle"> Menu </i>
                    <h2 class="fs-2 m-0 d-none d-md-block"> - Painel do usuário</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="dropdown-item"><a class="btn " href="#">Profile <i
                                            class="far fa-address-card"></i></a></li>
                                <li class="dropdown-item"><a class="btn " href="#">Settings <i
                                            class="far fa-cog"></i></a></li>
                                <li class="dropdown-item"><a class="btn btn-danger"
                                        href="{{ route('public.logout') }}">Logout <i class="fas fa-power-off"></i></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            @yield('content')
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
@section('plugins.Sweetalert2', true)
    @yield('js')
    <script>
        $(document).ready(() => {
            $(".list-group-item").each((i, e) => {
                if (e.href == window.location.href) {
                    e.classList.add("active")
                }
            })
        })
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
    </script>
    <style>
        #breadcrumb {
            margin-left: 25px;
        }

        :root {
            --main-bg-color: #113f67;
            --main-text-color: #113f67;
            --second-text-color: #38598b;
            --second-bg-color: #e7eaf6;
        }

        .primary-text {
            color: var(--main-text-color);
        }

        .second-text {
            color: var(--second-text-color);
        }

        .primary-bg {
            background-color: var(--main-bg-color);
        }

        .secondary-bg {
            background-color: var(--second-bg-color);
        }

        .rounded-full {
            border-radius: 100%;
        }

        #wrapper {
            overflow-x: hidden;
            background: rgb(18, 159, 187);
            background: linear-gradient(90deg, rgba(18, 159, 187, 1) 4%, rgba(103, 138, 179, 1) 45%, rgba(11, 7, 71, 1) 95%);
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin 0.25s ease-out;
            -moz-transition: margin 0.25s ease-out;
            -o-transition: margin 0.25s ease-out;
            transition: margin 0.25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        #menu-toggle {
            cursor: pointer;
        }

        .list-group-item {
            border: none;
            padding: 20px 30px;
            background: transparent;
            color: #e7eaf6;
        }

        .list-group-item.active {
            background: rgb(18, 159, 187);
            color: #e7eaf6;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .list-group-item:hover {
            background: rgb(18, 159, 187);
            color: #e7eaf6;
            font-weight: bold;
            font-size: 1.3rem;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
    </style>
</body>

</html>
