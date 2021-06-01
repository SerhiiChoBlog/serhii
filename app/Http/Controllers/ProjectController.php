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
        Visitor::incrementPageViews($request->segment(2), 'project', $request->ip());
        return view('projects.show', compact('project'));
    }
}
