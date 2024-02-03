<?php

namespace App\Http\Controllers;

use App\Models\User;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
            $root = Str::substr($value, 10);
            $root = str_replace('/', '\\', "/A{$root}");
            $name = explode("/", $value);
            $name = end($name);
            array_push($names, [
                "name" => $name,
                "methods" => (new ReflectionClass($root))->getMethods()
            ]);
        }
        // dd($this->getModels($path));
        dd($names);
    }

    public function getControllers()
    {
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action)) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $controllers[] = $action['controller'];
            }
        }
        dd($controllers);
    }
}
