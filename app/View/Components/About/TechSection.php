<?php

namespace App\View\Components\About;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TechSection extends Component
{
    public function __construct(public array $techs, public string $header)
    {
    }

    public function render(): View
    {
        return view('components.about.tech-section');
    }
}
