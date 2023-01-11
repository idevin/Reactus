@extends(session('theme'))

{{--@section('content')--}}
    {{--<section class="articles">--}}

        {{--<div class="container">--}}
            {{--@include(theme('includes.breadcrumbs'))--}}
        {{--</div>--}}

        {{--<div class="article-heading">--}}
            {{--<div class="container">--}}
                {{--<h1><strong>СТАТЬИ</strong></h1>--}}

                {{--@if(!empty($site->articles_description))--}}
                    {{--<div id="collapse-heading" class="panel-collapse collapse in">--}}
                        {{--{!! $site->articles_description !!}--}}
                    {{--</div>--}}

                    {{--<div class="collapse-toggle-wrapper">--}}
                        {{--<a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-heading" aria-expanded="true">--}}
                            {{--<span class="icon icon-toggle-section"></span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-8 col-lg-9">--}}

                    {{--<div class="view-section">--}}

                        {{--@if(count($articles->items()) > 0)--}}
                            {{--<div class="view-section-heading clearfix">--}}
                                {{--@include(theme('article.sort-search-panel'))--}}
                            {{--</div>--}}
                        {{--@endif--}}

                        {{--<div class="articles-list-view">--}}
                            {{--@include(theme('article.list-view'))--}}
                        {{--</div>--}}

                        {{--<div class="articles-grid-view">--}}
                            {{--@include(theme('article.grid-view'))--}}
                        {{--</div>--}}

                        {{--<div class="js-pagination js-articles-pagination">--}}
                            {{--@include(theme('partials.pagination'), ['paginator' => $articles])--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-4 col-lg-3">--}}
                    {{--<div class="sidebar sidebar-inner">--}}
                        {{--<div class="sidebar-block">--}}
                            {{--@include(theme('article.sidebar-popular'))--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
{{--@stop--}}
