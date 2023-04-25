<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Task;
use Illuminate\Http\Request;

class GanttController extends Controller
{

    public function index()
    {
        return view('dashboard.projects.statistics.gantt');
    }

    public function get()
    {
        $tasks = new Task();
        $links = new Link();

        return response()->json([
            'data' => $tasks->orderBy('sortorder')->get(),
            'links' => $links->all(),
        ]);
    }
}
