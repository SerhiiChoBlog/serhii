<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    private const ONE_HOUR_IN_SECONDS = 3600;

    public function index(): View
    {
        $projects = Cache::remember('projects', self::ONE_HOUR_IN_SECONDS, function () {
            return Project::query()
                ->orderBy('stars', 'DESC')
                ->get()
                ->toArray();
        });

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        return view('projects.show');
    }
}
