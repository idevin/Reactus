@extends(session('theme'))

@section('content')
    <section class="articles">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="article-heading">
                <div class="container">
                    <h1><strong>{{ $community->title }} </strong></h1>

                    <div id="collapse-heading" class="panel-collapse collapse in">
                        {!! $community->content !!}
                    </div>

                    <div class="collapse-toggle-wrapper">
                        <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-heading" aria-expanded="true">
                            <span class="icon icon-toggle-section"></span>
                        </a>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-9">

                        @include(theme('section.articles'))

                    </div>

                    {{-- sidebar --}}
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar sidebar-inner">

                            <div class="sidebar-block">
                                @include(theme('community.sidebar-sections'), ['id' => $community->id])
                            </div>

                            <div class="sidebar-block">
                                @include(theme('article.sidebar-discussed'))
                                @include(theme('article.sidebar-popular'))
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="btn-create-post"><span class="icon icon-pencil"></span></a>
    </section>

    @include(theme('home.more'))
    @include(theme('home.other'))

@stop