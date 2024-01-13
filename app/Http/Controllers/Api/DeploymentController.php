<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\DeployRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DeploymentController extends Controller
{
    public function __invoke(string $key): string
    {
        if ($key !== config('app.deploy_key')) {
            return 'Invalid deployment key!';
        }

        $project_root = base_path();
        $output = shell_exec("cd {$project_root} && ./pull 2>&1");

        if ($output === null || $output === false) {
            return 'Could not execute command';
        }

        $content = file_get_contents($project_root . '/deploy.json');

        if ($content === false) {
            return 'Could not read deploy.json file';
        }

        $json = json_decode($content, true, flags: JSON_THROW_ON_ERROR);

        $rules = new DeployRules($json);

        if ($rules->migrate) {
            $output .= shell_exec("cd {$project_root} && php artisan migrate 2>&1");
        }

        if ($rules->composer) {
            $output .= shell_exec("cd {$project_root} && /opt/cpanel/composer/bin/composer update --no-dev 2>&1");
        }

        if ($rules->cache) {
            $output .= shell_exec("cd {$project_root} && /opt/cpanel/composer/bin/composer cache 2>&1");
        }

        $output = rtrim($output, "\n");

        return $output;
    }
}
