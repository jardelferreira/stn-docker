<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div id="local"></div>
    <form action="{{ route('teste.locations.coodinates') }}" method="post">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="lat">Latitude</label>
            <input type="text" class="form-control" name="lat" id="lat" aria-describedby="helpIdLat"
                placeholder="-24.56518">
            <small id="helpIdLat" class="form-text text-muted">Informe uma latitude</small>
        </div>
        <div class="form-group">
            <label for="lng">Longitude</label>
            <input type="text" class="form-control" name="lng" id="lng" aria-describedby="helpIdLng"
                placeholder="-46.06518">
            <small id="helpIdLng" class="form-text text-muted">Informe uma Longitude</small>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <br>
    @if ($location->data->success)
        <div id="localIP">{{ $location->data->full }}</div>
    @else
        <div>{{ $location->data->message }}</div>
    @endif

</body>
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
                document.getElementById("lat").value = latitude
                document.getElementById("lng").value = longitude
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
        ), {
            enableHighAccuracy: true
        };
    } else {
        // O navegador não suporta Geolocation
        console.error("Seu navegador não suporta Geolocation.");
    }
</script>

</html>
