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

@if($ssr)
    <script>
        window.__INITIAL_STATE__ = {!! $ssr->state !!}
    </script>
@endif

@include('partials.foot')

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'BfHTCpm3qx';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
</body>
</html>
