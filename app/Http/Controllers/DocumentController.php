<?php

namespace App\Http\Controllers;

use App\Models\Stoks;
use App\Models\Project;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Sector;
use Illuminate\Support\Facades\Http;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $response =  Http::accept('application/json')->get("https://dev.virtualearth.net/REST/v1/Locations/-24.0877568,-46.6092032?includeEntityTypes=Address&o=json&key=AkAM8Qhsw58S516_zkjiK4pXLu5mNpFOGu0HrDzRtEJ9fSYlf9t_bk6ouAQaEAw4")->body();
        // dd(json_decode($response));

        // $response =  Http::accept('application/json')->post("https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyAqdoXdjUq5txykTMQsfwnkO1aTbx4kf-g")->body();
        // ['lat' => -24.1034164, 'lng' => 46.6510916]
        return $this->getGeolocation();

        return view('dashboard.documents.index', [
            'documents' => Document::orderBy("id", "DESC")->get(),
            'projects' => Project::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.documents.create', [
            'types' => Document::enumTypes(),
            'statuses' => Document::enumStatus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Document $document, StoreDocumentRequest $request)
    {
        if (!$request->hasFile('file')) {
            $request['arquive'] = "";
        }
        $rand = Str::random(10);
        $request['arquive'] = $request->file('file')->storeAs('public/files', "documents/{$rand}-{$request->type}-{$request->serie}.pdf");
        $document->create($request->all());
        return redirect()->route('dashboard.documents');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDocumentRequest  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }

    public function documentsJson()
    {

        return response()->json(['data' => Document::all()]);
    }

    public function attachDocument(Document $document, Stoks $stok)
    {
        // dd($stok->documents()->get());
        $stok->documents()->attach($document->id);
        // dd($stok);
        return redirect()->route('dashboard.sectors.stoks.documents', [$stok->sector_id, $stok->id])
            ->with("success", "O documento {$document->name}, foi vinculado ao produto.");
    }

    public function documentsAvaliable(Stoks $stok)
    {
        $documents = Document::whereNotIn('id', $stok->documents()->pluck('document_id'))->get();

        return view('dashboard.documents.attachStok', [
            'stok' => $stok,
            'documents' => $documents
        ]);
    }

    public function showFile(Document $document, Request $request)
    {
        if ($request->has("signature")) {
            if (!$request->hasValidSignature(false)) {
                abort(401);
            }
        }
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->name . '"'
        ];
        $path = \str_replace('public', 'storage', $document->arquive);

        return \response()->file($path, $header);
    }

    public function stoksAvailable(Request $request)
    {
        $sector = Sector::find($request->sector_id);

        // dd($sector->stoksWithoutDocument($request->document_id)->get());
        return view('dashboard.documents.stoksAvailables', [
            'sector' => $sector,
            'stoks' => $sector->stoksWithoutDocument($request->document_id)->get(),
            'document' => Document::find($request->document_id)
        ]);
    }

    public function stoksAttached(Request $request)
    {
        $sector = Sector::find($request->sector_id);
        $document = Document::find($request->document_id);
        // dd($document->stoks()->get());
        // dd($sector->stoksWithoutDocument($request->document_id)->get());
        return view('dashboard.documents.stoksAttacheds', [
            'sector' => $sector,
            'stoks' => $document->stoks()->get(),
            'document' => $document
        ]);
    }

    public function attachDocumentToStoks(Document $document, Request $request)
    {
        // dd($document);
        $document->stoks()->attach($request->stok_id);
        return redirect()->route('dashboard.documents')->with('success', "Documento vinculado itens de estoque com sucesso!");
    }

    public function detachDocumentToStoks(Document $document, Request $request)
    {
        // dd($document);
        $document->stoks()->detach($request->stok_id);
        return redirect()->route('dashboard.documents')->with('success', "Documento desvinculado itens de estoque com sucesso!");
    }

    public function getGeolocation($coordinates = null)
    {
        if(!$coordinates){

            $coordinates = $this->getCoordinates()['location'];
        }
        
        // Chave de API do Google Maps
        $apiKey = 'AIzaSyAqdoXdjUq5txykTMQsfwnkO1aTbx4kf-g'; // Substitua com sua chave de API real

        // Construir a URL da API Geocoding
        $geocodingUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$coordinates['lat']},{$coordinates['lng']}&key={$apiKey}";

        // Enviar requisição GET para a API Geocoding
        $response = Http::get($geocodingUrl);

        // Verificar se a requisição foi bem-sucedida (código de status 2xx)
        if ($response->successful()) {
            // Obter os dados da resposta JSON
            return $response->json();
        } else {
            // A requisição falhou, imprimir o código de status e mensagem de erro
            return "Erro: " . $response->status() . " - " . $response->body();
        }
    }

    public function getCoordinates()
    {
        $response = Http::post('https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyAqdoXdjUq5txykTMQsfwnkO1aTbx4kf-g', [
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
            return "Erro: " . $response->status() . " - " . $response->body();
        }
    }
}
