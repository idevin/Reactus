@extends(session('theme'))

@section('content')
    <section class="articles">
        <div class="container">
            @include(theme('includes.breadcrumbs'))
        </div>

        <div class="article-heading">
            <div class="container">
                <h1><strong>Сайты</strong></h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="view-section clearfix">

                        <div class="view-section-heading clearfix">
                            @include(theme('site.sort-search-panel'))
                        </div>

                        <div id="collapse-1" class="panel-collapse collapse in">

                            @include(theme('site.list-view'))
                            @include(theme('site.grid-view'))

                        </div>
                    </div>

                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="sidebar sidebar-inner">
                        <div class="sidebar-block">
                            @include(theme('article.sidebar-discussed'))
                            @include(theme('article.sidebar-popular'))
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop

