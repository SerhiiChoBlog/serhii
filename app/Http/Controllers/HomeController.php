<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $ip = $request->ip();

        if ($ip) {
            Visitor::incrementPageViews('/', 'home', $ip);
        }

        $pages = $this->getPages();

        return view('home', compact('pages'));
    }

    private function getPages(): array
    {
        $active_class = 'navbar-link--active bg-black/30 lg:bg-transparent';

        return [
            [
                'href' => route('posts.index'),
                'class' => 'bg-gradient-to-r from-[#d074a2] to-[#2a4b67]',
                'title' => 'Blog posts',
            ],
            [
                'href' => route('projects.index'),
                'class' => 'bg-gradient-to-r from-[#51895c] via-[#4c5f7d] to-[#51895c]',
                'title' => 'Open Source',
            ],
            [
                'href' => route('about-me'),
                'class' => 'bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1]',
                'title' => 'About',
            ],
            [
                'href' => route('about-me'),
                'class' => 'bg-gradient-to-r from-main-dark to-main',
                'title' => 'Contacts',
            ],
        ];
    }
}
