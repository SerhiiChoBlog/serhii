@if (app()->environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PDEVGVHPVM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-PDEVGVHPVM');
    </script>
@endif