<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiometricRequest;
use App\Http\Requests\UpdateBiometricRequest;
use App\Models\Biometric;
use App\Models\Employee;
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
        // $users = auth()->user()->projects()->with(['users','employees'])->get();
        // $array_users = array_merge($users->pluck("users.*.id")->toArray(),$users->pluck("employees.*.user_id")->toArray());
        // dd(array_unique(array_merge_recursive(...$array_users)));
        // dd(array_unique(...$array_users),$users->pluck("users.*.id")->toArray(),$users->pluck("employees.*.user_id")->toArray(),$array_users);
        return view('dashboard.biometrics.index', [
            'biometrics' => Biometric::with('user')->get(),
            'availiables' => auth()->user()->usersAvaliableToBiometric()
        ]);
    }

    public function check()
    {
        return view('dashboard.biometrics.check');
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

    public function getBiometricFromEmployee(Employee $employee)
    {
        $biometric = $employee->user->biometric()->first();
        if ($biometric) {
            return response()->json([
                'template' => $biometric->template,
                'success' => true
            ]);
        }
        return response()->json(['success' => false]);

    }
    
    public function getBiometricFromUser(User $user)
    {
        $biometric = $user->biometric()->first();
        if ($biometric) {
            return response()->json([
                'template' => $biometric->template,
                'success' => true
            ]);
        }
        return response()->json(['success' => false]);

    }

}
