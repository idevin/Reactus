{{ Form::model($section, ['url' => $url, 'theme' => 'bootstrap-vertical']) }}

@if($section->parent_id != null && ($site->manager(Auth::user(), 'section.move') || $section->manager($site, 'section.move')))
    <div class="form-group">
        <label for="parent">Родительский раздел</label>

        <div class="view-sort"> {{ Form::select('parent_id', $parent, $section->parent_id, ['class' => 'select-sort', 'id' => 'parent_id']) }}
        </div>
    </div>
@endif

@if($url == route('section.update', ['id' => $section->id]) && Auth::user()->can('section.transfer') && !empty($otherSections))

    <div class="form-group">
        <label for="other_section_id">Перенос раздела на другой ресурс</label>
        {{ Form::select('other_section_id', $otherSections, null, ['class' => 'select-sort', 'id' => 'other_section_id']) }}
    </div>
@endif

<div class="form-group">
    <label for="title">Название</label>
    {{ Form::text('title', $section->title, ['class' => 'form-control input-lg', 'id' => 'title']) }}
</div>

<div class="form-group">
    <label>Описание</label>
    {{ Form::textarea('content', $section->content, ['class' => 'form-control', 'id' => 'content']) }}
</div>

<div class="form-group">
    <label for="a-tags">Метки (через запятую)</label>

    {{ Form::text('tags', implode(',', $section->tags->pluck('name')->toArray()), ['class' => 'form-control input-lg tags-input', 'id' => 'a-tags', 'data-role' => 'tagsinput']) }}
</div>

<div class="form-group">
    <label>Загрузить картинку в шапку</label>

    <div class="preview-images">
        <div class="row">
            <div class="col-lg-12 preview-images-section">
                @if ($section->image && $section->imageUrl('1280x200', 'section'))
                    <img src="{{ $section->imageUrl('1280x200', 'section') }}" class="img-responsive js-preview-section" alt="1280x200">
                    <a href="#remove-Image" id="remove-image" class="remove-img icon-error"></a>
                @else
                    <img src="http://placehold.it/1280x200" class="img-responsive js-preview-section"/>
                @endif

            </div>
        </div>

        <div class="preview-images-upload">
            <div class="btn-upload">
                <input type="file" id="i-upload" class="js-fileupload-section" name="image" accept="image/*">

                <label for="i-upload" class="btn btn-info btn-lg btn-xlg js-fileupload-btn">Выбрать
                    изображение</label>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="form-group">
            <div class="checkbox">
                {{ Form::checkbox('filter_articles', 1, (boolean)$sectionSetting->filter_articles, ['id' => 'filter_articles']) }}
                <span class="checkbox-control"></span>
                <label for="filter_articles">Выводить фильтр статей </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_articles_sort">Сортировка статей</label>
                {{ Form::select('filter_articles_sort', $articlesSortOptions, null, ['id' => 'filter_articles_sort']) }}
            </div>
            <div class="view-sort col-md-6 col-lg-6">
                <label for="article_sort_direction">&nbsp;</label>
                {{ Form::select('filter_articles_sort_direction', ['asc' => 'По возрастанию', 'desc' => 'По убыванию'], null, ['id' => 'filter_articles_sort_direction']) }}
            </div>
        </div>

        <div class="form-group row">
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_articles_view">Вид</label>
                {{ Form::select('filter_articles_view', $articlesViewOptions, null, ['id' => 'filter_articles_view']) }}
            </div>

            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_articles_view">Кол-во статей на странице</label>
                {{ Form::select('articles_limit', \App\Models\Article::$limits, $sectionSetting->articles_limit, ['id' => 'articles_limit']) }}
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="checkbox">
                {{ Form::checkbox('filter_sections', 1, (boolean)$sectionSetting->filter_sections, ['id' => 'filter_sections']) }}
                <span class="checkbox-control"></span>
                <label for="filter_sections">Выводить фильтр разделов </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_sections_sort">Сортировка разделов</label>
                {{ Form::select('filter_sections_sort', $sectionsSortOptions, null, ['id' => 'filter_sections_sort']) }}
            </div>
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_sections_sort_direction">&nbsp;</label>
                {{ Form::select('filter_sections_sort_direction', ['asc' => 'По возрастанию', 'desc' => 'По убыванию'], null, ['id' => 'filter_sections_sort_direction']) }}
            </div>
        </div>

        <div class="form-group row">
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_sections_view">Вид</label>
                {{ Form::select('filter_sections_view', $sectionsViewOptions, null, ['id' => 'filter_sections_view']) }}
            </div>
            <div class="view-sort col-md-6 col-lg-6">
                <label for="filter_articles_view">Кол-во разделов на странице</label>
                {{ Form::select('sections_limit', \App\Models\Section::$limits, $sectionSetting->sections_limit, ['id' => 'sections_limit']) }}
            </div>
        </div>
        <div class="row">
            @if(\Auth::user()->can('section.rating'))
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="checkbox">
                            {{ Form::checkbox('show_rating', 1, (boolean)$sectionSetting->show_rating, ['id' => 'show_rating']) }}
                            <span class="checkbox-control"></span>
                            <label for="show_rating">Показывать рейтинг</label>
                        </div>
                    </div>
                </div>
            @endif

            @if(\Auth::user()->can('section.hide'))
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="checkbox">
                            {{ Form::checkbox('is_secret', 1, (boolean)$section->is_secret, ['id' => 'is_secret']) }}
                            <span class="checkbox-control"></span>
                            <label for="is_secret">Скрыть раздел</label>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <div class="checkbox">
                        {{ Form::checkbox('show_article_author', 1, (boolean)$sectionSetting->show_article_author, ['id' => 'show_article_author']) }}
                        <span class="checkbox-control"></span>
                        <label for="show_article_author">Показывать автора статей</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row section-form-action">
    <div class="col-xs-12">
        <div class="col-sm-6 text-left">
            @if(isset($section->id))
                {{--<button type="button" id="remove-section" class="btn btn-danger btn-xlg btn-lg">Удалить раздел</button>--}}
            @endif
        </div>
        <div class="col-sm-6 text-right">
            <button type="submit" class="btn btn-success btn-xlg btn-lg">Опубликовать</button>
        </div>
    </div>
</div>

<input type="hidden" name="filename" class="js-uploaded-file" value="{{$section->image}}"/>

<input type="hidden" name="token" value="{{$user->auth_token}}"/>

{{ Form::close() }}