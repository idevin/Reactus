@extends(session('theme'))

@section('content')
    <section class="create-article  js-create-article">
        <div class="container">
            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <h2 class="main-heading">{{ $title }}</h2>

                    <div class="content-body">
                        <article class="article-body">

                            @include(theme('partials.flash'))

                            {{ Form::model($article, ['url' => $formAction, 'theme' => 'bootstrap-vertical']) }}
                            @include(theme('article.form-fields'))
                            {{ Form::close() }}
                        </article>

                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="sidebar sidebar-inner">
                        <div class="sidebar-block">
                            @include(theme('article.sidebar-revisions'))
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')

{{--    {{ Html::script('/js/ckeditor/ckeditor.js') }}--}}
{{--    {{ Html::script('/js/ckeditor/plugins/imagebrowser/plugin.js') }}--}}

    <script>
        $(function () {
            CKEDITOR.config.extraPlugins = 'imagebrowser';
            CKEDITOR.config.imageBrowser_listUrl = '/storage-manager/browse';
            CKEDITOR.config.filebrowserImageUploadUrl = '/storage-manager/upload';
            CKEDITOR.replace('content');
        });
    </script>
@endsection
