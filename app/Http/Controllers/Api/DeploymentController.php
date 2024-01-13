<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\DeployRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DeploymentController extends Controller
{
    public function __invoke(string $key): JsonResponse
    {
        if ($key !== config('app.deploy_key')) {
            return response()->json(['error' => 'Invalid deployment key!', 403]);
        }

        $project_root = base_path();
        $output = shell_exec("cd {$project_root} && ./pull");

        if ($output === null || $output === false) {
            return response()->json(['error' => 'Could not execute command'], 403);
        }

        $content = file_get_contents($project_root . '/deploy.json');

        if ($content === false) {
            return response()->json(['error' => 'Could not read deploy.json file'], 403);
        }

        $json = json_decode($content, true, flags: JSON_THROW_ON_ERROR);

        $rules = new DeployRules($json);

        if ($rules->migrate) {
            $output .= shell_exec("cd {$project_root} && php artisan migrate");
        }

        if ($rules->composer) {
            $output .= shell_exec("cd {$project_root} && /opt/cpanel/composer/bin/composer update --no-dev");
        }

        if ($rules->cache) {
            $output .= shell_exec("cd {$project_root} && /opt/cpanel/composer/bin/composer cache");
        }

        $output = rtrim($output, "\n");

        return response()->json(['error' => null, 'output' => $output]);
    }
}
