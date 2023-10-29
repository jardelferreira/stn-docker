<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $path;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->path = app_path() . "/Models";
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where("id", Auth::user()->id)->first();
        if ($user->can('dashboard')) {
            return view('home');
        }
        Auth::setUser($user);
        Auth::logout();
        return redirect()->route('welcome')->withErrors(['permission' => 'Você não possui permissão para acessar a Dashboard, favor contactar o Admin.']);
    }


    function getModels($path = "start")
    {
        $path = $path != "start" ? $path : $this->path;
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getModels($filename));
            } else {
                $out[] = substr($filename, 0, -4);
            }
        }
        $names = [];
        foreach ($out as $value) {
            $name = explode("/",$value);
            array_push($names,end($name));
        } 
        // dd($this->getModels($path));
        dd($names);
    }

}
