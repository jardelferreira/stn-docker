<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function redirectWithUrl($url)
    {
        return redirect($url);
    }
    
    public function redirectWithUuid($uuid)
    {
        # code...
    }
}
