<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiometricRequest;
use App\Http\Requests\UpdateBiometricRequest;
use App\Models\Biometric;
use App\Models\User;

use function GuzzleHttp\Promise\all;

class BiometricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Biometric $biometric)
    {
        // return response()->json(auth()->user()->usersAvaliableToBiometric());
        return view('dashboard.biometrics.index', [
            'biometrics' => Biometric::with('user')->get(),
            'availiables' => auth()->user()->usersAvaliableToBiometric()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBiometricRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiometricRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function show(Biometric $biometric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function edit(Biometric $biometric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBiometricRequest  $request
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBiometricRequest $request, Biometric $biometric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biometric $biometric)
    {
        if ($biometric->count()) {
            $user_id = $biometric->user()->first()->id;
            $biometric->delete();
            return response()->json([
                "success" => true,
                'id' => $user_id
            ]);
        }
        return response()->json([
            "success" => false
        ]);
    }

    public function getUsers()
    {
        $users = User::usersAvaliableToBiometric();
        return response()->json([
            'users' => $users,
            'count' => $users->count()

        ]);
    }

    public function bioauth()
    {
        $template = auth()->user()->biometric()->first()->template;
        return response()->json([
            'template' => $template,
            'success' => $template != "" || $template != null,
            'user_id' => auth()->user()->id
        ]);
    }

    public function downloadBiometrics()
    {
        return response()->json(auth()->user()->usersWithBiometric()->get());
    }
}
