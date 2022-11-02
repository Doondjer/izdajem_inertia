<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @production
            @if(config('app_settings.values.enable_google_analytics'))
                <!-- Global site tag (gtag.js) - Google Analytics -->
                <script defer src="https://www.googletagmanager.com/gtag/js?id=UA-216815091-1"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'UA-216815091-1');
                </script>

            @endif
        @endproduction

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preload" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">

        <meta name="csrf_token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        @routes
        @vite('resources/js/app.js')
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#cb2027">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "name": "{{ env('APP_NAME') }}",
                "alternateName": "{{ env('APP_NAME') }}",
                "url": "{{ asset('/') }}",
                "image": "https://izdajem.rs/android-chrome-512x512.png",
                "sameAs":[
                    @foreach(array_filter(config('app_settings.values.social')) as $name => $social)
                        "{{ $social['url'] }}"@if(!$loop->last),@endif
                    @endforeach
                ],
                "areaServed": "Beograd i Srbija",
                "logo": "https://izdajem.rs/android-chrome-512x512.png"
            }
        </script>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "WebSite",
                "url": "{{ asset('/') }}",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "{{ route('home') . '?q={query}' }}",
                    "query-input": "required
                    name=query"
                }
            }
        </script>
            @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        @production
            @if(config('app_settings.values.enable_mouseflow'))
                <script type="text/javascript">
                    window._mfq = window._mfq || [];
                    (function() {
                        var mf = document.createElement("script");
                        mf.type = "text/javascript"; mf.defer = true;
                        mf.src = "//cdn.mouseflow.com/projects/e3b40ab9-3fcd-4edf-90e4-d233befb6b86.js";
                        document.getElementsByTagName("head")[0].appendChild(mf);
                    })();
                </script>
            @endif
        @endproduction
    </body>
</html>
