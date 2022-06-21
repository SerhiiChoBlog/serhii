<?php

namespace App\View\Components\About;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SitesSection extends Component
{
    public array $sites = [
        [
            'image' => 'storage/tools/site-sho.png',
            'title' => 'Shobar',
            'href' => 'https://shobar.com.ua/',
        ],
        [
            'image' => 'storage/tools/site-olexiy.png',
            'title' => 'Olexiy Chornenkyi',
            'href' => 'https://jiskelo.dev/',
        ],
        [
            'image' => 'storage/tools/site-zoo.png',
            'title' => 'ZooZooZoo',
            'href' => 'https://zoo-zoo-zoo.com.ua/',
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
