<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard.financeiro.providers.index',[
            'providers' => Provider::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('dashboard.financeiro.providers.create',[
            'headquarters' => Provider::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProviderRequest $request)
    {
        $fornecedor = $request->all();
        $fornecedor['headquarters'] = 0;
        $fornecedor['user_id'] = 1;
        Provider::create($fornecedor);

        return \redirect()->route('dashboard.providers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProviderRequest  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $provider = Provider::where("id",$request->id)->first();
        if (is_object($provider)) {
            $provider->delete();
        }

        return redirect()->route('dashboard.providers.index');
    }

    public function projects(Provider $provider)
    {
        return view('dashboard.financeiro.providers.projects',[
            'projects' => Project::all(),
            'provider' => $provider,
            'provider_projects' => $provider->projects()->pluck('project_id')->toArray(),

        ]);
    }

    public function syncProjects(Request $request, Provider $provider)
    {
        $provider->projects()->sync($request->projects);
       
        return redirect()->route('dashboard.providers.projects',$provider);
    }

    function get(Request $request) {
        $providers = Provider::where("corporate_name","LIKE","%$request->q%")
        ->orWhere("cnpj","LIKE","%$request->q%")
        ->orWhere("fantasy_name","LIKE","%$request->q%")
        ->get();

        return response()->json($providers);
    }
}
