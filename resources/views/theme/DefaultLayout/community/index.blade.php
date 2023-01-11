@extends(session('theme'))

@section('content')
    <section class="communities">

        <div class="container">
            @include(theme('includes.breadcrumbs'))
        </div>

        <div class="article-heading">
            <div class="container">
                <h1><strong>СООБЩЕСТВА</strong></h1>

                <div id="collapse-heading" class="panel-collapse collapse in">
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
                <div class="col-md-12 col-lg-12">

                    <div class="view-section">

                        <div class="view-section-heading clearfix">
                            @include(theme('community.sort-search-panel'))
                        </div>

                        @include(theme('community.list-view'))
                        @include(theme('community.grid-view'))

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection