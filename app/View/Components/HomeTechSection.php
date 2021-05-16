<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeTechSection extends Component
{
    public function __construct(public array $techs, public string $header)
    {
    }

    public function render(): View
    {
        return view('components.home-tech-section');
    }
}
