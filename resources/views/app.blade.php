<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$page['props']['title'] ?? 'FlareMetrics'}}</title>
        <meta name="description" content="{{$page['props']['description'] ?? ''}}">

        <!-- Socials -->
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{$page['props']['meta_url'] ?? ''}}">
        <meta property="og:title" content="{{$page['props']['title'] ?? ''}}">
        <meta property="og:description" content="{{$page['props']['description'] ?? ''}}">
        <meta property="og:image" content="{{$page['props']['meta_image'] ?? ''}}">
        <meta property="fb:app_id" content="194089965498359">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{$page['props']['meta_url'] ?? ''}}">
        <meta property="twitter:title" content="{{$page['props']['title'] ?? ''}}">
        <meta property="twitter:description" content="{{$page['props']['description'] ?? ''}}">
        <meta property="twitter:image" content="{{$page['props']['meta_image'] ?? ''}}">


        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y7GSEE70KT"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-Y7GSEE70KT', {
            send_page_view: false
        });
        </script>
    </head>

    <body class="font-sans antialiased">
        <div id="teleport-target"></div>
        @inertia
    </body>

</html>
<script
async
src="https://platform.twitter.com/widgets.js"
charset="utf-8"
></script>