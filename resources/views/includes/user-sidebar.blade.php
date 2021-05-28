@auth
    <nav class="user-sidebar">
        <ul>
            <li>
                <a href="{{ route('home') }}">
                    <i class="fas fa-home icon-profile-menu-line"></i>
                    <span>Site</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-columns icon-profile-menu-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->is('admin/posts') ? 'active' : ''}}">
                    <i class="fas fa-newspaper icon-profile-menu-line"></i>
                    <span>Posts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tags.index') }}" class="{{ request()->is('admin/tags') ? 'active' : ''}}">
                    <i class="fas fa-tags icon-profile-menu-line"></i>
                    <span>Tags</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.page_views.index') }}" class="{{ request()->is('admin/page_views') ? 'active' : ''}}">
                    <i class="fas fa-eye icon-profile-menu-line"></i>
                    <span>Page views</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.visitors.index') }}" class="{{ request()->is('admin/visitors') ? 'active' : ''}}">
                    <i class="fas fa-users icon-profile-menu-line"></i>
                    <span>Visitors</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.social-shares.index') }}" class="{{ request()->is('admin/social-shares') ? 'active' : ''}}">
                    <i class="fas fa-share-alt icon-profile-menu-line"></i>
                    <span>Shares</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit()"
                >
                    <i class="fas fa-sign-out-alt icon-profile-menu-line"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
@endauth
