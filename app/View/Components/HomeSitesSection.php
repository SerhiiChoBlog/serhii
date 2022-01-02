<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeSitesSection extends Component
{
    public array $sites = [
        [
            'image' => 'storage/tools/site-sho.png',
            'title' => 'Shobar',
            'href' => 'https://shobar.com.ua/',
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
        return view('components.home-sites-section');
    }
}
