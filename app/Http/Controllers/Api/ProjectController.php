<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    private const ONE_HOUR_IN_SECONDS = 3600;

    public function index(): array
    {
        return Cache::remember('projects', self::ONE_HOUR_IN_SECONDS, function () {
            return Project::query()
                ->orderBy('stars', 'DESC')
                ->get()
                ->toArray();
        });
    }
}
