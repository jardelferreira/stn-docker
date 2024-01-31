@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
@section('geolocation')
    <script>
        function getGeolocation() {
            console.log("geolocal")
            // Verificar se o navegador suporta a API Geolocation
            if ("geolocation" in navigator) {
                // Obter a localização atual
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Sucesso: As coordenadas estão disponíveis em position.coords
                        lat = position.coords.latitude
                        lng = position.coords.longitude
                        new_coordinates = JSON.stringify({
                            "lat": lat,
                            "lng": lng
                        })
                        if (!(new_coordinates == localStorage.getItem("coordinates"))) {
                            $.get(`${window.location.origin}/dashboard/geolocation?lat=${lat}&lng=${lng}`).then((
                                res) => {
                                if (res.data.success) {
                                    localStorage.setItem("coordinates", JSON.stringify(new_coordinates));
                                    localStorage.setItem("geolocation", JSON.stringify(res.data));
                                } else {
                                    localStorage.setItem("geolocation", JSON.stringify(res.data))
                                }
                            })
                        }

                    },
                    function(error) {
                        $.get(`${window.location.origin}/geolocation`).then((res) => {
                            if (res.success) {
                                localStorage.setItem("geolocation", JSON.stringify(res.data));
                            } else {
                                localStorage.setItem("geolocation", JSON.stringify(res.data))
                            }
                        })
                        // Erro: Tratar erros aqui
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                localStorage.setItem("geolocation", JSON.stringify({
                                    "sucess": false,
                                    "full": "Permissão negada pelo usuário."
                                }))
                                alert("Permissão negada pelo usuário.");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                localStorage.setItem("geolocation", JSON.stringify({
                                    "sucess": false,
                                    "full": "Informações de localização indisponíveis."
                                }))
                                alert("Informações de localização indisponíveis.");
                                break;
                            case error.TIMEOUT:
                                localStorage.setItem("geolocation", JSON.stringify({
                                    "sucess": false,
                                    "full": "Tempo esgotado ao obter localização."
                                }))
                                alert("Tempo esgotado ao obter localização.");
                                break;
                            case error.UNKNOWN_ERROR:
                                localStorage.setItem("geolocation", JSON.stringify({
                                    "sucess": false,
                                    "full": "Erro desconhecido ao obter localização."
                                }))
                                alert("Erro desconhecido ao obter localização.");
                                break;
                        }
                    }
                ), {
                    enableHighAccuracy: true
                };
            } else {
                // O navegador não suporta Geolocation_error
                if (localStorage.geolocation) {
                    $("#location").val(JSON.parse(localStorage.geolocation).full)
                } else {
                    $.get(`${window.location.origin}/geolocation`).then((res) => {
                        if (res.success) {
                            localStorage.setItem("geolocation", JSON.stringify(res.data));
                        } else {
                            localStorage.setItem("geolocation", JSON.stringify({
                                "sucess": false,
                                "full": "Navegador não suporta Geolocation."
                            }));
                        }
                    })
                }
            }
        }
    </script>
@endsection
@section('plugins.Sweetalert2', true)
