<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CacheKey;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Parsedown;

class FetchGithubProjects extends Command
{
    protected $signature = 'projects:fetch';
    protected $description = 'Fetches github projects and saves them into a database table';

    public function handle(): void
    {
        try {
            $projects = $this->fetchProjects();

            Project::query()->truncate();
            Project::query()->insert($projects->toArray());

            Cache::forget(CacheKey::PROJECTS);

            $this->info(sprintf('%d projects has been uploaded to a database', $projects->count()));
        } catch (RequestException $e) {
            $this->error($e->getMessage());
            logger()->error($e);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Http\Client\RequestException
     */
    private function fetchProjects(): Collection
    {
        $projects_url = config('app.github_projects_url');
        $readme_url = Str::of(config('app.github_readme_url'));

        $projects = Http::get($projects_url)->throw()->collect();

        $mit_projects = $projects->filter(function ($project) {
            $license = $project['license']['key'] ?? null;
            return $license === 'mit';
        });

        return $mit_projects->map(function ($project) use ($readme_url) {
            $readme_url = str_replace('{repo}', $project['name'], (string) $readme_url);

            return [
                'name' => $project['name'],
                'title' => Str::of($project['name'])->replace('-', ' ')->ucfirst(),
                'url' => $project['html_url'],
                'description' => $project['description'],
                'language' => $project['language'],
                'content' => $this->getContent($readme_url),
                'stars' => (int) $project['stargazers_count'],
                'created_at' => date('Y-m-d H:i:s', strtotime($project['created_at']))
            ];
        });
    }

    private function getContent(string $readme_url): string
    {
        try {
            $content = Http::get($readme_url)->throw()->body();
            $parser = new Parsedown();
            return $parser->text($content);
        } catch (RequestException $e) {
            logger()->error($e);
            return '';
        }
    }
}
