<?php

namespace App\View\Components\About;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectsSection extends Component
{
    public array $sites = [];

    public function __construct()
    {
        $this->sites = config('technologies.projects');
    }

    public function render(): View
    {
        return view('components.about.projects-section');
    }
}
