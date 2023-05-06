<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{

    public function redirectWithUrl(Shortcut $shortcut)
    {
        return redirect($shortcut->url);
    }

    public function redirectToUrl($shortcut)
    {
        $shortcut = Shortcut::where("shortcut", $shortcut)->first();
        if (!$shortcut) {
            abort(404);
        }
        return redirect($shortcut->url);
    }

    public function redirectToSecure($shortcut)
    {
        $shortcut = Shortcut::where("shortcut", $shortcut)->first();
        if (!$shortcut) {
            abort(404);
        }
        return redirect($shortcut->secure_url);
    }
}
