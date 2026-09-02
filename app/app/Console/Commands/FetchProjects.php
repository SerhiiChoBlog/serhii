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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Parsedown;

class FetchProjects extends Command
{
    protected $signature = 'projects:fetch';
    protected $description = 'Fetches projects and saves them into a database projects table';

    private const EXCLUDE_ACCOUNTS = [
        'SerhiiCho',
        'SerhiiChoBlog',
        'SerhiiChoGames',
        'lab-zero',
        'act',
    ];

    private const EXCLUDE_REPOS = [
        'pages',
        'smooth-loader-vue',
    ];

    public function handle(): void
    {
        $projects = collect();

        try {
            for ($page = 1; $page < 10; $page++) {
                $this->info("Fetching page {$page}...");
                $result = $this->fetchProjects($page);

                if ($result->count() === 0) {
                    $this->info("Page {$page} is empty! Stopping...");
                    $this->info("================================================");
                    break;
                }

                $projects = $projects->merge($result->toArray());
                $this->info("Found {$result->count()} projects on page {$page}");
                $this->info("================================================");
            }

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
     * @return Collection<int, array<string, mixed>>
     * @throws RequestException
     */
    private function fetchProjects(int $page): Collection
    {
        $url = config('services.codeberg.repos_url') . "&page={$page}";

        $response = Http::retry(3)->get($url);
        $projects = $response->collect();

        $filtered_projects = $projects->filter(function ($project) {
            $is_docs = str_contains($project['name'], 'github.io');
            $exclude_accounts = !in_array($project['owner']['login'], self::EXCLUDE_ACCOUNTS);
            $exclude_repos = !in_array($project['name'], self::EXCLUDE_REPOS);
            return !$is_docs && $exclude_accounts && $exclude_repos;
        });

        /** @var Collection<int, array<string, mixed>> $result */
        $result = collect();

        foreach ($filtered_projects as $project) {
            $has_homepage = str_contains($project['website'], '.codeberg.page');
            $readme_url = str_replace('{full-repo-name}', $project['full_name'], config('services.codeberg.readme_url'));

            $result->push([
                'name' => $project['name'],
                'title' => Str::of($project['name'])->replace('-', ' ')->ucfirst(),
                'url' => $has_homepage ? $project['website'] : $project['html_url'],
                'description' => $project['description'],
                'language' => $project['language'],
                'has_homepage' => $has_homepage,
                'content' => $has_homepage ? '' : $this->getContent($readme_url),
                'stars' => (int) $project['stars_count'],
                'updated_at' => date('Y-m-d H:i:s', strtotime($project['updated_at'])),
                'created_at' => date('Y-m-d H:i:s', strtotime($project['created_at'])),
            ]);
        }

        return $result;
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
