<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;

class SearchController extends Controller
{
    public function index(string $query): array
    {
        $posts = Post::query()
            ->select('id', 'title', 'slug')
            ->where('title', 'LIKE', "%$query%")
            ->orWhere('intro', 'LIKE', "%$query%")
            ->where('is_published', true)
            ->limit(5)
            ->get();

        $projects = Project::query()
            ->selectRaw('id, concat(title, " (", language, ")") as title, name as slug, language')
            ->where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->limit(5)
            ->get();

        return compact('posts', 'projects');
    }
}
