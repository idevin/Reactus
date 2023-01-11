@if(!isset($profile) || $profile != true)
        <!DOCTYPE html>
<html lang="ru">
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
        {{ env('DOMAIN') }} -

        @if(isset($title))
            {{$title}}
        @else
            @if(get_site())
                {{strip_tags(get_site()->title)}}
            @endif
        @endif

    </title>
    <link rel="stylesheet" type="text/css"
          href="http://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext">
    <link rel="stylesheet" type="text/css"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic-ext">
    <link rel="stylesheet" type="text/css" href="/theme/{{session('theme')}}/assets/style/new-preloader.css">
    <link rel="stylesheet" type="text/css" href="/theme/{{session('theme')}}/assets/style/style.css">

    <script>
        var baseUrl = '{{ $ajaxBaseUrl }}';

        window.geo = {!!  $geo !!};

        /**
         * Token or null
         * @type {string}
         */
        @if(Auth::user())
            window.user = {!! Auth::user() !!};
        window.permissions = {!! $permissions !!};
        @else
            window.user = null;
        window.permissions = null;
        @endif
    </script>
{{--    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>--}}
    @if (get_site() && get_site()->favicon)
        <link rel="icon" type="image/png" href="{{get_site()->imageUrl('180x180', 'favicon')}}" sizes="180x180">
    @endif
</head>
<body class="{{Route::currentRouteName()}}">

<div class="start-loading">
    <div class="start-box-loading"></div>
</div>

<div id="app"></div>

<div id="configTheme">

</div>
<script src="{{ asset('/theme/' . session('theme') . '/assets/js/bundle.js') }}"></script>
</body>
</html>
@endif