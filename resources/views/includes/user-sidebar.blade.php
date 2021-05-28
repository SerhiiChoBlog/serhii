@auth
    <nav class="user-sidebar">
        <ul>
            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/posts') ? 'active' : ''}}">
                <a href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Posts</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/tags') ? 'active' : ''}}">
                <a href="{{ route('admin.tags.index') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Tags</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/page_views') ? 'active' : ''}}">
                <a href="{{ route('admin.page_views.index') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Page views</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/visitors') ? 'active' : ''}}">
                <a href="{{ route('admin.visitors.index') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Visitors</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/social-shares') ? 'active' : ''}}">
                <a href="{{ route('admin.social-shares.index') }}">
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Shares</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit()"
                >
                    <i class="fas fa-plus-circle icon-profile-menu-line"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
@endauth
