<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Project;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function index()
    {
        return view('publico.index');
    }

    public function projects()
    {
        return view('publico.projects.principal',[
            'projects' => Project::all()
        ]);
    }

    public function bases(Project $project)
    {
        return view('publico.projects.bases.index',[
            'project' => $project,
            'bases'   => $project->bases()->get()
        ]);
    }

    public function stokFromProject(Project $project)
    {
        // dd($project->sectors()->with('stoks')->get());
        return view('publico.projects.stoks',[
            'project' => $project
        ]);
    }

    public function stokFromBase(Base $base)
    {
        // dd($base->sectors()->with('stoks')->get());
        return view('publico.projects.bases.stoks',[
            'base' => $base
        ]);
    }
}
