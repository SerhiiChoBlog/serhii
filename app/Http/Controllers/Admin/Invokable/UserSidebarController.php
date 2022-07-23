<?php

namespace App\Http\Controllers\Admin\Invokable;

use App\Http\Controllers\Controller;

class UserSidebarController extends Controller
{
    public function __invoke(): array
    {
        return [
            [
                'href' => route('home'),
                'title' => 'Site',
                'icon' => 'fa-home',
            ],
            [
                'href' => route('admin.dashboard'),
                'title' => 'Dashboard',
                'icon' => 'fa-columns',
            ],
            [
                'href' => route('admin.posts.index'),
                'title' => 'Posts',
                'icon' => 'fa-newspaper',
            ],
            [
                'href' => route('admin.tags.index'),
                'title' => 'Tags',
                'icon' => 'fa-tags',
            ],
            [
                'href' => route('admin.page_views.index'),
                'title' => 'Post views',
                'icon' => 'fa-eye',
            ],
            [
                'href' => route('admin.visitors.index'),
                'title' => 'Visitors',
                'icon' => 'fa-users',
            ],
            [
                'href' => route('admin.social-shares.index'),
                'title' => 'Shares',
                'icon' => 'fa-share-alt',
            ],
            [
                'href' => route('admin.referrers.index'),
                'title' => 'Referrers',
                'icon' => 'fa-link',
            ],
            [
                'href' => route('admin.hits.index'),
                'title' => 'Hits',
                'icon' => 'fa-shoe-prints',
            ],
            [
                'href' => route('logout'),
                'title' => 'Logout',
                'icon' => 'fa-sign-out-alt',
            ],
        ];
    }
}
