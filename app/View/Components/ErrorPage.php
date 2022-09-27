<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorPage extends Component
{
    public function __construct(
        public string $header,
        public int $code,
    ) {
    }

    public function render(): View
    {
        return view('components.error-page');
    }
}
