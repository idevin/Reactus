@extends(session('theme'))

@section('content')
    <section class="create-article  js-create-article">
        <div class="container">
            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-8 col-lg-12">
                    <h2 class="main-heading">Создать раздел</h2>

                    <div class="content-body">
                        <article class="section-body">

                            @include(theme('partials.flash'))
                            @include(theme('section.form'))

                        </article>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection


@section('scripts')
    <script src="/js/tooltip.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/lang/summernote-ru-RU.js"></script>

    <script>
        $('#content').summernote(wysiwigOptions);
    </script>
@endsection
