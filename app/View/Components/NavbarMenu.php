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
                'href' => route('projects.index'),
                'class' => request()->is('projects') ? $active_class : '',
                'title' => 'Open Source',
            ],
            [
                'href' => route('about-me'),
                'class' => request()->is('about-me') ? $active_class : '',
                'title' => 'About',
            ],
        ];
    }
}
