<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CacheKey;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Parsedown;

class FetchGithubProjects extends Command
{
    protected $signature = 'projects:fetch';
    protected $description = 'Fetches github projects and saves them into a database projects table';

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
            Log::error($e->getMessage());
        }
    }

    /**
     * @return Collection<int, Project>
     * @throws RequestException
     */
    private function fetchProjects(): Collection
    {
        $urls = config('services.github.projects_urls');
        $readme_url = Str::of(config('services.github.readme_url'));

        $responses = Http::pool(function (Pool $pool) use ($urls) {
            $result = [];

            foreach ($urls as $url) {
                $result[] = $pool->get($url);
            }

            return $result;
        });

        $projects = array_reduce($responses, function ($carry, $response) {
            $projects = $response->json();

            if (is_array($projects)) {
                return $carry->merge($projects);
            }

            return $carry;
        }, new Collection());

        $mit_projects = $projects->filter(function ($project) {
            $license = $project['license']['key'] ?? null;
            return $license === 'mit';
        });

        return $mit_projects->map(function ($project) use ($readme_url) {
            $readme_url = str_replace('{repo}', $project['name'], (string) $readme_url);
            $has_homepage = $project['homepage'] !== '';

            /** @var Project $result */
            $result = [
                'name' => $project['name'],
                'title' => Str::of($project['name'])->replace('-', ' ')->ucfirst(),
                'url' => $has_homepage ? $project['homepage'] : $project['html_url'],
                'description' => $project['description'],
                'language' => $project['language'],
                'has_homepage' => $has_homepage,
                'content' => $has_homepage ? '' : $this->getContent($readme_url),
                'stars' => (int) $project['stargazers_count'],
                'updated_at' => date('Y-m-d H:i:s', strtotime($project['pushed_at'])),
                'created_at' => date('Y-m-d H:i:s', strtotime($project['created_at'])),
            ];

            return $result;
        });
    }

    private function getContent(string $readme_url): string
    {
        try {
            $content = Http::get($readme_url)->throw()->body();
            $parser = new Parsedown();
            return $parser->text($content);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return '';
        }
    }
}
