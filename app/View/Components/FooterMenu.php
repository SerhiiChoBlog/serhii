<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterMenu extends Component
{
    public function render(): View
    {
        return view('components.footer-menu', [
            'menu_items' => $this->getMenuItems(),
        ]);
    }

    private function getMenuItems(): array
    {
        return [
            [
                'href' => route('home'),
                'title' => 'Home',
                'is_active' => request()->is('/'),
            ],
            [
                'href' => route('posts.index'),
                'title' => 'Blog',
                'is_active' => request()->is('posts'),
            ],
            [
                'href' => route('series.index'),
                'title' => 'Series',
                'is_active' => request()->is('series'),
            ],
            [
                'href' => route('projects.index'),
                'title' => 'Open Source',
                'is_active' => request()->is('projects'),
            ],
            [
                'href' => route('about-me'),
                'title' => 'About',
                'is_active' => request()->is('about-me'),
            ],
            [
                'href' => route('subscribe'),
                'title' => 'Subscribe',
                'is_active' => request()->is('subscribe'),
            ],
        ];
    }
}
