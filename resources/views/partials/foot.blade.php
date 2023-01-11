@if($ssr)
    <script>
        window.__INITIAL_STATE__ = {!! $ssr->state !!}
    </script>
@endif

@if(isset($assets['runtime~main.js']))
    <script src="/node-core/client/theme/{{$theme}}/assets/js/{{$assets['runtime~main.js']}}"></script>
@endif

@if(isset($assets['vendors~main.js']))
    <script src="/node-core/client/theme/{{$theme}}/assets/js/{{$assets['vendors~main.js']}}"></script>
@endif

@if(isset($assets['main.js']))
    <script src="/node-core/client/theme/{{$theme}}/assets/js/{{$assets['main.js']}}"></script>
@endif

@if($site && $site->jivosite)
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function () {
            var widget_id = '{{$site->jivosite}}';
            var d = document;
            var w = window;

            function l() {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = '//code.jivosite.com/script/widget/' + widget_id;
                var ss = document.getElementsByTagName('script')[0];
                ss.parentNode.insertBefore(s, ss);
            }

            if (d.readyState == 'complete') {
                l();
            } else {
                if (w.attachEvent) {
                    w.attachEvent('onload', l);
                } else {
                    w.addEventListener('load', l, false);
                }
            }
        })();
    </script>
    <!-- {/literal} END JIVOSITE CODE -->
@endif