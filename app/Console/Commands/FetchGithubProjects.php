<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FetchGithubProjects extends Command
{
    protected $signature = 'projects:fetch';
    protected $description = 'Fetches github projects and saves them into a database table';

    public function handle(): int
    {
        try {
            $projects = $this->fetchProjects();

            Project::query()->truncate();
            Project::query()->insert($projects->toArray());

            $this->info(sprintf('%d projects has been uploaded to a database', $projects->count()));
        } catch (RequestException $e) {
            $this->error($e->getMessage());
            logger()->error($e);
        }

        return 0;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Http\Client\RequestException
     */
    private function fetchProjects(): Collection
    {
        $url = config('app.github_projects_url');

        $projects = Http::get($url)->throw()->collect();

        $mit_projects = $projects->filter(function ($project) {
            $license = $project['license']['key'] ?? null;
            return $license === 'mit';
        });

        return $mit_projects->map(function ($project) {
            return [
                'name' => $project['name'],
                'title' => Str::of($project['name'])->replace('-', ' ')->ucfirst(),
                'url' => $project['html_url'],
                'description' => $project['description'],
                'language' => $project['language'],
                'stars' => (int) $project['stargazers_count'],
                'created_at' => date('Y-m-d H:i:s', strtotime($project['created_at']))
            ];
        });
    }
}
