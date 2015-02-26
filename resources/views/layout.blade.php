<!DOCTYPE HTML>
<html>
    <head>
        <title>MS Reformas</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />

        <link rel="stylesheet" href="{{ $homeUrl }}/css/alert.css" />
        <link rel="stylesheet" href="{{ $homeUrl }}/css/css-social-buttons/zocial.css" />

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
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=835292159882756&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        @yield('content')
    </body>
</html>
