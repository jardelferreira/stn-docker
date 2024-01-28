@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Painel adm.</p>
    <div id="local"></div>
    <script>
        // Verificar se o navegador suporta a API Geolocation
        if ("geolocation" in navigator) {
            // Obter a localização atual
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // Sucesso: As coordenadas estão disponíveis em position.coords
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('local').textContent = (`Latitude: ${latitude}, Longitude: ${longitude}`);

                },
                function(error) {
                    // Erro: Tratar erros aqui
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            alert("Permissão negada pelo usuário.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert("Informações de localização indisponíveis.");
                            break;
                        case error.TIMEOUT:
                            alert("Tempo esgotado ao obter localização.");
                            break;
                        case error.UNKNOWN_ERROR:
                            alert("Erro desconhecido ao obter localização.");
                            break;
                    }
                }
            ),{ enableHighAccuracy: true };
        } else {
            // O navegador não suporta Geolocation
            console.error("Seu navegador não suporta Geolocation.");
        }
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
