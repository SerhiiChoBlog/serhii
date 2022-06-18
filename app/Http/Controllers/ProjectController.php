<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::getCachedProjects();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project, Request $request): View
    {
        $slug = $request->segment(2);
        $ip = $request->ip();

        if ($slug && $ip) {
            Visitor::incrementPageViews($slug, 'project', $ip);
        }

        return view('projects.show', compact('project'));
    }
}
