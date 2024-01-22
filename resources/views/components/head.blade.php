@if (app()->environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PDEVGVHPVM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-PDEVGVHPVM');
    </script>
@endif
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="author" content="Serhii Chornenkyi">
<meta name="description" content="@stack('description', "Serhii's blog is a great place to learn about web development. If you are eager to learn how to build optimized, responsive and modern web")">
<meta property="og:locale" content="en_US">
{!! new \App\CanonicalTag() !!}

<link
    rel="icon"
    href="{{ asset('favicon.png') }}"
    type="image/png"
    sizes="50x50"
/>

<title>@stack('title'){{ request()->is('/') ? "Blog for developers | {S} Serhii" : '' }}</title>
