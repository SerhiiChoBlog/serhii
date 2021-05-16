<nav class="navbar is-dark mb-6">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}" class="navbar-item">
                <b>SERHII<span class="has-text-info">CHO</span></b>
            </a>

            <a role="button" class="navbar-burger">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-end">
                @auth
                    <a href="{{ route('home') }}" class="navbar-item has-stripe {{ request()->is('/') ? 'is-active' : '' }}">About</a>
                    <a href="{{ route('posts.index') }}" class="navbar-item has-stripe {{ request()->is('posts') ? 'is-active' : '' }}">Blog</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
