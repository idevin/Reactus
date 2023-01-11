@php
    $site = get_site()
@endphp

@if ($site && $site->setting && $site->setting->google_code)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$site->setting->google_code}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{$site->setting->google_code}}');
    </script>
@endif

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
@if ($site && $site->setting && $site->setting->google_verification)
    <meta name="google-site-verification" content="{{$site->setting->google_verification}}"/>
@endif
@if ($site && $site->setting && $site->setting->yandex_verification)
    <meta name="yandex-verification" content="{{$site->setting->yandex_verification}}"/>
@endif
@include('partials.meta')
@if ($site && $site->faviconUrlV2())
    <link rel="icon" href="{{$site->faviconUrlV2()['original']}}"
          sizes="180x180">
@endif
<link rel="stylesheet" type="text/css"
      href="/node-core/client/theme/{{$theme}}/assets/style/new-preloader.css">
<style type="text/css" id="template_styles"></style>
@if(isset($assets['vendors~main.css']))
    <link rel="stylesheet" type="text/css"
          href="/node-core/client/theme/{{$theme}}/assets/style/{{$assets['vendors~main.css']}}">
@endif

@if(isset($assets['main.css']))
    <link rel="stylesheet" type="text/css"
          href="/node-core/client/theme/{{$theme}}/assets/style/{{$assets['main.css']}}">
@endif

<script>
    window.geo = {!!  $geo !!};

    @if(env('DEVELOPMENT') == true)
        window.port = {{config('app.ws.development')}};
    @else
        window.port = {{config('app.ws.production')}};
    @endif

            @if(env('DEVELOPMENT') == true)
        window.RECAPTCHA = '{{env('DEV_RECAPTCHA')}}';
    @else
        window.RECAPTCHA = '{{env('PROD_RECAPTCHA')}}';
    @endif

    /**
     * Token or null
     * @type {string}
     */
    @if ((!$ssr || !property_exists($ssr, 'html')) && Auth::user())
        window.user = {!! Auth::user() !!};

    @if(isset($permissions))
        window.permissions = {!! $permissions !!};
    @endif
            @endif

            @if(isset($settings) && !empty($settings->google_code))
        window.GoogleMetrikaCode = '{{$settings->google_code}}';
    @endif
            @if(isset($settings) && !empty($settings->yandex_code))
        window.YandexMetrikaCode = '{{$settings->yandex_code}}';
    @endif
        window.startLoad = new Date().getTime()
</script>

@if(config('netgamer.google_ads') == true)
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3557155264868780",
            enable_page_level_ads: true
        });
    </script>
@endif

@if(!empty($settings->yandex_code))
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter{{$settings->yandex_code}} = new Ya.Metrika2({
                        id:{{$settings->yandex_code}},
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true,
                        webvisor: true
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/tag.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks2");
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/{{$settings->yandex_code}}" style="position:absolute; left:-9999px;"
                  alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
@endif