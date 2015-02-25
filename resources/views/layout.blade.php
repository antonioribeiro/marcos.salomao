<!DOCTYPE HTML>
<html>
    <head>
        <title>MS Reformas</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />

        <link rel="stylesheet" href="{{ $homeUrl }}/css/alert.css" />

        <script src="{{ $homeUrl }}/js/jquery.min.js"></script>
        <script src="{{ $homeUrl }}/js/skel.min.js"></script>
        <script src="{{ $homeUrl }}/js/init.js"></script>

        <noscript>
            <link rel="stylesheet" href="{{ $homeUrl }}/css/skel.css" />
            <link rel="stylesheet" href="{{ $homeUrl }}/css/style.css" />
            <link rel="stylesheet" href="{{ $homeUrl }}/css/style-desktop.css" />
            <link rel="stylesheet" href="{{ $homeUrl }}/css/style-noscript.css" />
        </noscript>
    </head>

    <body>
        @yield('content')
    </body>
</html>
