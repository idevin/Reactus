{{--@if($section->image)--}}
{{--@section('header')--}}
    {{--@set('bgImage', $section->imageUrl('1280x200', 'section'))--}}

    {{--<header class="main-header-podsite" style="--}}
            {{--background: #000000 url('{{$bgImage}}') no-repeat center;--}}
            {{--background-size: auto 100%;--}}
            {{--">--}}

        {{--<div>--}}
            {{--<div class="hero">--}}
                {{--<div class="container">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="row logo-container">--}}
                            {{--@include(theme('partials.logo'))--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</header>--}}

{{--@endsection--}}
{{--@endif--}}

@extends(session('theme'))

{{--@section('content')--}}
    {{--<section class="articles">--}}
        {{--<div class="container">--}}

            {{--@include(theme('includes.breadcrumbs'))--}}

            {{--<div class="article-heading">--}}
                {{--<div class="container">--}}
                    {{--<h1><strong>{{ $section->title }}</strong></h1>--}}

                    {{--@if(!empty($section->transfer_to_section) && \Auth::user() && ($section->manager($site, 'article.create') || $site->manager(Auth::user(), 'article.create')))--}}
                        {{--<div class="alert alert-danger" style="display: block;">--}}
                            {{--Раздел на стадии переноса--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--<div id="collapse-heading" class="panel-collapse collapse in">--}}
                        {{--{!! $section->content !!}--}}
                    {{--</div>--}}

                    {{--<div class="collapse-toggle-wrapper">--}}
                        {{--<a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-heading"--}}
                           {{--aria-expanded="true">--}}
                            {{--<span class="icon icon-toggle-section"></span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-md-8 col-lg-9">--}}

                    {{--@include(theme('partials.flash'))--}}

                    {{--@if(count($sections->items()) > 0)--}}
                        {{--<div class="view-section" data-section-id="{{$section->id}}">--}}

                            {{--<div class="view-section-heading">--}}
                                {{--<h2 class="main-heading">РАЗДЕЛЫ</h2>--}}

                                {{--@include(theme('section.sort-search-panel'))--}}
                            {{--</div>--}}

                            {{--@include(theme('section.subsections'), compact('sections'))--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--@include(theme('section.articles'), compact('section'))--}}

                    {{--@if(count($c_sections) > 0)--}}
                        {{--@include(theme('article.communities'), compact('c_sections', 'section'))--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{-- sidebar --}}
                {{--<div class="col-md-4 col-lg-3">--}}
                    {{--<div class="sidebar sidebar-inner">--}}

                        {{--<div class="sidebar-block">--}}

                            {{--@if(empty($section->transfer_to_section))--}}
                                {{--@include(theme('section.section-action'))--}}
                            {{--@endif--}}

                            {{--@include(theme('article.sidebar-discussed'))--}}
                            {{--@include(theme('article.sidebar-popular'))--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@if(empty($section->transfer_to_section))--}}
                {{--@if(\Auth::user() && ($section->manager($site, 'article.create') || $site->manager(Auth::user(), 'article.create')))--}}
                    {{--@if(!$section->isRoot())--}}
                        {{--@include(theme('article.create-btn'), [--}}
                          {{--'route' => route('section.article.view-create-form', ['section' => $section->path])--}}
                        {{--])--}}
                    {{--@else--}}
                        {{--@include(theme('article.create-btn'), [--}}
                         {{--'route' => route('article.view-create-form')--}}
                       {{--])--}}
                    {{--@endif--}}
                {{--@endif--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</section>--}}

    {{--@include(theme('home.more'))--}}

{{--@stop--}}