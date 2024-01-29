<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Geolocation extends Model
{
    use HasFactory;

    private $google_key, $bing_key;
    protected $ipAddress;

    public function __construct()
    {
        $this->google_key = env("GOOGLE_MAPS_KEY");
        $this->bing_key = env("BING_MAPS_KEY");
        $this->ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    }

    public function getCoordinatesGoogle()
    {
        $response = Http::post("https://www.googleapis.com/geolocation/v1/geolocate?key={$this->google_key}", [
            'homeMobileCountryCode' => 55,
            'homeMobileNetworkCode' => 15,
            'radioType' => 'gsm',
            'carrier' => 'Vivo',
            'considerIp' => true,
        ]);

        // Verificar se a requisição foi bem-sucedida (código de status 2xx)
        if ($response->successful()) {
            // Obter os dados da resposta JSON
            return $response->json();
        } else {
            // A requisição falhou, imprimir o código de status e mensagem de erro
            return response()->json(["data" => $response->body(), "success" => false]);
        }
    }

    public function getGeolocationGoogle($lat = null, $lng = null)
    {
        if (!($lat && $lng)) {
            if ($coordinates = $this->getCoordinatesGoogle()) {
                $lat = $coordinates['location']['lat'];
                $lng = $coordinates['location']['lng'];
            }
        }

        // Construir a URL da API Geocoding
        $geocodingUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$this->google_key}";

        // Enviar requisição GET para a API Geocoding
        $response = Http::get($geocodingUrl);

        // Verificar se a requisição foi bem-sucedida (código de status 2xx)
        if ($response->successful()) {
            // Obter os dados da resposta JSON
            return $response->json();
        } else {
            // A requisição falhou, imprimir o código de status e mensagem de erro
            return response()->json(["data" => $response->body(), "success" => false]);
        }
    }

    public function getGeolocationBing($lat = null, $lng = null)
    {
        if (!($lat && $lng)) {
            if ($coordinates = $this->getCoordinatesGoogle()) {
                $lat = $coordinates['location']['lat'];
                $lng = $coordinates['location']['lng'];
            };
        }
        $response = Http::accept('application/json')
            ->get("https://dev.virtualearth.net/REST/v1/Locations/{$lat},{$lng}?includeEntityTypes=Address&o=json&key={$this->bing_key}")->body();

        return response()->json([
            "data" => $response
        ]);
    }

    public function getGeolocationWithIpCAEPI()
    {
        $geolocation = HTTP::get("https://www.caepionline/geolocationIP/{$this->ipAddress}");
        return json_decode($geolocation);
    }

    public function getGeolocationWithCoodinatesCAEPI($lat, $lng)
    {
        $geolocation = HTTP::get("https://www.caepionline/geolocationLatLng?{$lat}=-24.1034222&{$lng}=-46.61248");
        return json_decode($geolocation);
    }
}
