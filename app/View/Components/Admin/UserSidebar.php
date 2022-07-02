<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserSidebar extends Component
{
    public function __construct()
    {
    }

    public function render(): View
    {
        return view('components.admin.user-sidebar');
    }

    public function links(): array
    {
        return [
            [
                'href' => route('home'),
                'title' => 'Site',
                'icon' => 'fa-home',
                'class' => '',
            ],
            [
                'href' => route('admin.dashboard'),
                'title' => 'Dashboard',
                'icon' => 'fa-columns',
                'class' => request()->is('admin/dashboard') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.posts.index'),
                'title' => 'Posts',
                'icon' => 'fa-newspaper',
                'class' => request()->is('admin/posts') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.tags.index'),
                'title' => 'Tags',
                'icon' => 'fa-tags',
                'class' => request()->is('admin/tags') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.page_views.index'),
                'title' => 'Page views',
                'icon' => 'fa-eye',
                'class' => request()->is('admin/page-views') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.visitors.index'),
                'title' => 'Visitors',
                'icon' => 'fa-users',
                'class' => request()->is('admin/visitors') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.social-shares.index'),
                'title' => 'Shares',
                'icon' => 'fa-share-alt',
                'class' => request()->is('admin/social-shares') ? 'bg-main' : '',
            ],
            [
                'href' => route('admin.referrers.index'),
                'title' => 'Referrers',
                'icon' => 'fa-link',
                'class' => request()->is('admin/referrers') ? 'bg-main' : '',
            ],
            [
                'href' => route('logout'),
                'title' => 'Logout',
                'icon' => 'fa-sign-out-alt',
                'class' => '_logout-button',
            ],
        ];
    }
}
