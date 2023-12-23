<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class DeploymentController extends Controller
{
    public function __invoke(): string
    {
        $project_root = base_path();

        return shell_exec("cd {$project_root} && ./pull 2>&1") ?? 'No output';
    }
}
