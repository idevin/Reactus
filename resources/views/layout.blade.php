@if (Route::currentRouteName() == 'home')
    @set('body_class', 'home')
    @set('bg_image', '/assets/img/hero-bg.jpg')
@else
    @set('body_class', '')
    @set('bg_image', '/assets/img/podsite-bg.jpg')
    @endif
    <!doctype html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ idnToUtf8(env('DOMAIN')) }}</title>
        <link rel="stylesheet" type="text/css"
              href="http://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext">
        <link rel="stylesheet" type="text/css"
              href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic-ext">
        <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
        <!--[if lt IE 9]>
        <script src="js/html5shiv/dist/html5shiv.min.js"></script>
        <![endif]-->
    </head>

    <body class="{{ $body_class }}">

    @include(theme('partials.navbar', true))

    @if(isset($profile) && $profile == true)
        @include(theme('partials.profile_menu', true))
    @else
        @include(theme('partials.menu', true))
    @endif

    @yield('content')


    @include(theme('partials.footer', true))
    @include(theme('partials.modals', true))

    <div class="bg-image-wrapper" style="background-image: url({{ $bg_image }});"></div>

    <!-- build:js:inline js/production.path.js -->
    <script>
        var baseUrl = '{{ $ajaxBaseUrl }}';
    </script>
    <!-- /build -->
    <script src="{{ asset('js/all.min.js') }}"></script>

    @yield('scripts')

    </body>
    </html>