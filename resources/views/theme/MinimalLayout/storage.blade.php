<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(isset($keywords))
        <meta name="keywords" content="{{$keywords}}">
    @endif

    @if(isset($description))
        <meta name="description" content="{{$description}}">
    @endif

    <title>
        {{ env('DOMAIN') }}

        @if(isset($title))
        &mdash; {{$title}}
        @else
        @if(Session::get('site') && Session::get('site')->title)
        &mdash; {{strip_tags(Session::get('site')->title)}}
        @endif
        @endif
    </title>
    {{--<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic-ext">--}}
    <!--[if lt IE 9]>
    <script src="/js/html5shiv/dist/html5shiv.min.js"></script>
    <![endif]-->

    <script>
        var baseUrl = '{{ $ajaxBaseUrl }}';

        window.geo = {!!  $geo !!};

        /**
         * Token or null
         * @type {string}
         */
        @if(Auth::user())
            window.user = {!! Auth::user() !!};
        @else
            window.user = null;
        window.permissions = null;
        @endif
    </script>

{{--    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>--}}
    <script src="{{ asset('/theme/' . session('theme') . '/assets/js/all.min.js') }}"></script>

    <script src="/theme/{{session('theme')}}/assets/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/theme/{{session('theme')}}/assets/style/preloader.css">
    <link rel="stylesheet" type="text/css" href="/theme/{{session('theme')}}/assets/style/style.css">
    <link rel="stylesheet" type="text/css" href="/theme/{{session('theme')}}/assets/style/legacy.css">

    @if (get_site() && get_site()->favicon)
        <link rel="icon" type="image/png" href="{{get_site()->imageUrl('180x180', 'favicon')}}" sizes="180x180">
    @endif
</head>

<body class="{{Route::currentRouteName()}}">

@include(theme('partials.flash'))

@yield('storage')

@yield('scripts')

@include(theme('partials.scripts'))


</body>
</html>