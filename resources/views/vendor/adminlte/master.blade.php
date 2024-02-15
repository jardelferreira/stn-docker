<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/486fc227d4.js" crossorigin="anonymous"></script>
    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'SGLT'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js"
        integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        Date.prototype.addHours = function(h) {
            this.setHours(this.getHours() + h);
            return this;
        }
    </script>
    <script>
        function getGeolocation() {
            console.log("geolocal")
            // Verificar se o navegador suporta a API Geolocation
            if ("geolocation" in navigator) {
                // Obter a localização do usuário
                return navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Sucesso: As coordenadas estão disponíveis em position.coords
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        if ((typeof localStorage.coordinates == 'string')) {
                            local = JSON.parse(localStorage.coordinates)
                            if ((local.lat.toFixed(1) == latitude.toFixed(1)) & (local.lng.toFixed(1) == longitude
                            .toFixed(1))) {
                                geolocation = JSON.parse(localStorage.geolocation)
                                if (!localStorage.reaproveita) {
                                    localStorage.reaproveita = 0
                                }
                                localStorage.reaproveita = parseInt(localStorage.reaproveita) +1
                                console.log("mesma")
                                console.log(localStorage.geolocation)
                            } else {
                                localStorage.reaproveita = 0

                                localStorage.setItem("coordinates", JSON.stringify({"lat":latitude,"lng":longitude}));
                                $.get(
                                        `${window.location.origin}/dashboard/geolocation?lat=${latitude}&lng=${longitude}`
                                    )
                                    .then((
                                        res) => {
                                        if (res.success) {
                                            $("#location").val(JSON.stringify(res.full).replace('"',""))
                                            localStorage.setItem("geolocation", JSON.stringify(res.full));
                                        } else {
                                            $.get(`${window.location.origin}/dashboard/geolocation`).then((
                                                resp) => {
                                                if (res.success) {
                                                    $("#location").val(JSON.stringify(res.full).replace('"',""))
                                                    localStorage.setItem("geolocation", JSON.stringify(res
                                                        .full));
                                                } else {
                                                    $("#location").val(JSON.stringify(res.full).replace('"',""))
                                                    localStorage.setItem("geolocation",
                                                        "Não foi possível obter a localização.");
                                                }
                                            })
                                        }
                                    })
                            }
                        } else {
                            console.log("não é string")
                            localStorage.setItem("coordinates", JSON.stringify({"lat":latitude,"lng":longitude}));
                            console.log(`coordinates= ${latitude},${longitude}`)
                            localStorage.reaproveita = 0
                            date = new Date()
                            time = date.getTime()
                            $.get(`${window.location.origin}/dashboard/geolocation?lat=${latitude}&lng=${longitude}&time=${time}`)
                                .then((
                                    res) => {
                                    if (res.success) {
                                        $("#location").val(JSON.stringify(res.full).replace('"',""))
                                        localStorage.setItem("geolocation", JSON.stringify(res.full));
                                    } else {
                                        localStorage.removeItem("coordinates");
                                        $.get(`${window.location.origin}/dashboard/geolocation`).then((
                                            resp) => {
                                            if (res.success) {
                                                $("#location").val(JSON.stringify(res.full).replace('"',""))
                                                localStorage.setItem("geolocation", JSON.stringify(res
                                                    .full));
                                            } else {
                                                $("#location").val(JSON.stringify(res.full).replace('"',""))
                                                localStorage.setItem("geolocation",
                                                    "Não foi possível obter a localização.");
                                            }
                                        })
                                    }
                                })
                        }
                    },
                    function(error) {
                        // Erro: Tratar erros aqui
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                console.error("Permissão negada pelo usuário.");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                console.error("Informações de localização indisponíveis.");
                                break;
                            case error.TIMEOUT:
                                console.error("Tempo esgotado ao obter localização.");
                                break;
                            case error.UNKNOWN_ERROR:
                                console.error("Erro desconhecido ao obter localização.");
                                break;
                        }
                    }
                );
            } else {

                $.get(`${window.location.origin}/dashboard/geolocation`).then((resp) => {
                    if (res.success) {
                        $("#location").val(JSON.stringify(res.full).replace('"',""))
                        localStorage.setItem("geolocation", JSON.stringify(res.data));
                    } else {
                        $("#location").val(JSON.stringify(res.full).replace('"',""))
                        localStorage.setItem("geolocation", "Não foi possível obter a localização.");
                    }
                })
            }
        }
    </script>
    @yield('adminlte_js')

</body>

</html>
