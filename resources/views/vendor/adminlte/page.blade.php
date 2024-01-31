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
    {{-- canvas --}}
    <script>
        function signatureCanvas() {

            Swal.fire({
                title: "Assine o documento no campo abaixo",
                html: signatureHtml(),
                width: 580,
                showCancelButton: true,
            })

            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;
            // ctx.moveTo(60,100);
            // ctx.lineTo(500,100)
            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);

            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);

            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {

            }, false);

            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            }, false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.innerHTML = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                sigText.innerHTML = dataUrl;
                sigImage.setAttribute("src", dataUrl);
            }, false);

        };
    </script>
@section('plugins.Sweetalert2', true)
