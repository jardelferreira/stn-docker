<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where("id",Auth::user()->id)->first();
        if($user->can('dashboard')){
            return view('home');
        }
        Auth::setUser($user);
        Auth::logout();
        return redirect()->route('welcome')->withErrors(['permission' => 'Você não possui permissão para acessar a Dashboard, favor contactar o Admin.']);
    }
}
