<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavbarMenu extends Component
{
    public function render(): View
    {
        return view('components.navbar-menu');
    }

    public function getMenuItems(): array
    {
        $active_class = 'navbar-link--active bg-black/30 lg:bg-transparent';

        return [
            [
                'href' => route('home'),
                'class' => request()->is('/') ? $active_class : '',
                'title' => 'Home',
            ],
            [
                'href' => route('posts.index'),
                'class' => request()->is('posts') ? $active_class : '',
                'title' => 'Blog',
            ],
            [
                'href' => route('subscribe'),
                'class' => request()->is('subscribe') ? $active_class : '',
                'title' => 'Subscribe',
            ],
        ];
    }
}
