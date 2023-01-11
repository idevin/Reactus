@extends(session('theme'))

@section('content')
    <section class="settings">
        <div class="container">
            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h2 class="main-heading">Настройки</h2>

                    <div class="content-body">
                        <article class="article-body">

                            @include(theme('partials.flash'))

                            {{ Form::model($site, ['url' => route('site.settings.update'), 'theme' => 'bootstrap-vertical']) }}

                            <div class="form-group">
                                <div class="checkbox">
                                    {{ Form::checkbox('filter_articles', 1, (boolean)$site->filter_articles, ['id' => 'filter_articles']) }}
                                    <span class="checkbox-control"></span>
                                    <label for="filter_articles">Выводить фильтр статей </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_articles_sort">Сортировка статей</label>
                                    {{ Form::select('filter_articles_sort', $articlesSortOptions, null, ['id' => 'article_sort']) }}
                                </div>
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="article_sort_direction">&nbsp;</label>
                                    {{ Form::select('filter_articles_sort_direction', ['asc' => 'По возрастанию', 'desc' => 'По убыванию'], null, ['id' => 'article_sort']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_articles_view">Вид</label>
                                    {{ Form::select('filter_articles_view', $articlesViewOptions, null, ['id' => 'filter_articles_view']) }}
                                </div>
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_articles_view">Кол-во статей на странице</label>
                                    {{ Form::select('articles_limit', ['3' => '3', '6' => '6', '10' => '10', '20' => '20'], $site->articles_limit, ['id' => 'articles_limit']) }}
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="checkbox">
                                    {{ Form::checkbox('filter_sections', 1, (boolean)$site->filter_sections, ['id' => 'filter_sections']) }}
                                    <span class="checkbox-control"></span>
                                    <label for="filter_sections">Выводить фильтр разделов </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_sections_sort">Сортировка разделов</label>
                                    {{ Form::select('filter_sections_sort', $sectionsSortOptions, null, ['id' => 'article_sort']) }}
                                </div>
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_sections_sort_direction">&nbsp;</label>
                                    {{ Form::select('filter_sections_sort_direction', ['asc' => 'По возрастанию', 'desc' => 'По убыванию'], null, ['id' => 'article_sort']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_sections_view">Вид</label>
                                    {{ Form::select('filter_sections_view', $sectionsViewOptions, null, ['id' => 'filter_sections_view']) }}
                                </div>

                                <div class="view-sort col-md-6 col-lg-6">
                                    <label for="filter_articles_view">Кол-во разделов на странице</label>
                                    {{ Form::select('sections_limit', ['3' => '3', '6' => '6', '10' => '10', '20' => '20'], $site->sections_limit, ['id' => 'sections_limit']) }}
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    {{ Form::submit('Сохранить настройки', ['class' => 'edit btn btn-success btn-lg
                                                  btn-block'])}}
                                </div>
                            </div>


                            {{ Form::close() }}
                        </article>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')

@endsection
