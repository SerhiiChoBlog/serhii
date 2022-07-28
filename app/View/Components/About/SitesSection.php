<?php

namespace App\View\Components\About;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SitesSection extends Component
{
    public array $sites = [
        [
            'image' => 'storage/tools/site-sho.webp',
            'title' => 'Shobar',
            'href' => 'https://shobar.com.ua/',
        ],
        [
            'image' => 'storage/tools/site-zoo.webp',
            'title' => 'ZooZooZoo',
            'href' => 'https://zoo-zoo-zoo.com.ua/',
        ],
        [
            'image' => 'storage/tools/site-olexiy.webp',
            'title' => 'Jiskelo',
            'href' => 'https://jiskelo.dev/',
        ],
    ];

    public function __construct()
    {
    }

    public function render(): View
    {
        return view('components.about.sites-section');
    }
}
