{{--@if(count($otherRecent) > 0 || count($otherPopular) > 0 || count($otherBest) > 0 || count($otherDiscussed) > 0)--}}
    {{--<section class="other">--}}
        {{--<div class="container">--}}
            {{--<h2 class="main-heading inverse">О ДРУГОМ</h2>--}}

            {{--<div class="row">--}}
                {{--<div class="topic-list topic-list-inverse">--}}

                    {{--@include(theme('home.scrollable-block'), ['heading' => 'ПОСЛЕДНЕЕ', 'list' => $otherRecent, 'data_url' => 'other/recent'])--}}

                    {{--@include(theme('home.scrollable-block'), ['heading' => 'ЧИТАЕМОЕ', 'list' => $otherPopular, 'data_url' => 'other/popular'])--}}

                    {{--@include(theme('home.scrollable-block'), ['heading' => 'ЛУЧШЕЕ', 'list' => $otherBest, 'data_url' => 'other/best'])--}}

                    {{--@include(theme('home.scrollable-block'), ['heading' => 'ОБСУЖДАЕМОЕ', 'list' => $otherDiscussed, 'data_url' => 'other/discussed'])--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
{{--@endif--}}
