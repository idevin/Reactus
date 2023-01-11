<!DOCTYPE html>
<html lang="ru">
<head>
    @include('partials.head')
</head>
<body>

@if (!$ssr || !$ssr->html)
    <div class="start-loading">
        <div class="start-box-loading"></div>
    </div>

    <div id="app"></div>
@else
    {!!$ssr->html!!}
@endif

<div id="configTheme">

</div>
<div id="popup_container" ></div>

@include('partials.foot')

</body>
</html>
