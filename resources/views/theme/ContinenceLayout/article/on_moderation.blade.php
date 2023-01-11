@extends(session('theme'))

@section('content')
    <section class="single-article">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="view-section no-m">
                        <div class="article-toggle">
                            <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-article" aria-expanded="true">
                                <span class="icon icon-toggle-section"></span>
                            </a>
                        </div>

                        <h1 class="page-heading">{{ $article->title }}</h1>

                        <div id="collapse-article" class="panel-collapse collapse in">
                            Статья на модерации
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="sidebar sidebar-inner">

                        <div class="sidebar-block">
                            @include(theme('article.sidebar-sections'))
                        </div>

                        <div class="sidebar-block">
                            @include(theme('article.sidebar-discussed'))
                            @include(theme('article.sidebar-popular'))
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include(theme('home.other'))

@endsection