@if (!$ssr || !$ssr->metaTags)

    @if(isset($title))
        <title>{{$title}}</title>
        <meta property="og:title" content="{{$title}}"/>
        <meta name="twitter:title" content="{{$title}}">
    @endif

    @if(isset($description))
        <meta name="description" content="{{$description}}">
        <meta property="og:description" content="{{$description}}"/>
        <meta name="twitter:description" content="{{$description}}">
    @endif

    <meta property="og:type" content="website"/>

    @if(isset($image))
        <meta property="og:image" content="{{$image}}"/>
        <meta name="twitter:image:src" content="{{$image}}">
    @endif
    @if(isset($url))
        <meta name="twitter:domain" content="{{$url}}">
        <meta name="twitter:url" content="{{$url}}">
        <link rel="canonical" href="{{$url}}"/>
        <meta property="og:url" content="{{$url}}"/>
    @endif
@else
    {!!$ssr->metaTags!!}
@endif