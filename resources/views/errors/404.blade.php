<!DOCTYPE html>
<html lang="ru">
<head>
    @include('partials.head', ['ssr' => null, 'permissions' => null])
</head>
<body>

<div class="start-loading">
    <div class="start-box-loading"></div>
</div>

<div id="app"></div>

<div id="configTheme"></div>

<div id="popup_container"></div>

@include('partials.foot', ['ssr' => null])

</body>
</html>
