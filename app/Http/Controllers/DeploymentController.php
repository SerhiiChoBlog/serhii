<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\DeployRules;

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
            $output .= shell_exec("cd {$project_root} && composer install 2>&1");
        }

        return $output;
    }
}
