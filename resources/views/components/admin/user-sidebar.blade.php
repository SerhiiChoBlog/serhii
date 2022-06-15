@php
    /**
     * @var callable $links
     * @var array{href:string, title:string, icon:string, class:string} $link
     */
@endphp

@auth
    <nav class="user-sidebar">
        <ul>
            @foreach ($links() as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="{{ $link['class'] }}">
                        <i class="fas {{ $link['icon'] }} icon-profile-menu-line"></i>
                        <span>{{ $link['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endauth
