@extends(session('theme'))

@section('content')
    <section class="create-article  js-create-article">
        <div class="container">
            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-12 col-lg-12">
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
