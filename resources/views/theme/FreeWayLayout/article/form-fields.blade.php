<div class="form-group">
    <label for="a-title">Заголовок статьи</label>
    {{ Form::text('title', null, ['class' => 'form-control input-lg', 'id' => 'a-title']) }}
</div>

<div class="form-group">
    <label for="a-tags">Теги</label>
    {{ Form::text('tags', $tags_text, ['class' => 'form-control input-lg tags-input', 'id' => 'a-tags', 'data-role' => 'tagsinput']) }}
</div>

<script>
    $(function () {

        var tagInput = $('.bootstrap-tagsinput input[type="text"]');

        function highlight(s, t) {
            var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(t) + ")", "ig");
            return s.replace(matcher, "<strong>$1</strong>");
        }

        tagInput.autocomplete({
            minLength: 0,
            source: function (request, response) {

                $.ajax({
                    url: '/api/storage/search_tag',
                    dataType: 'json',
                    data: {
                        token: window.user.auth_token,
                        name: request.term
                    },
                    success: function (data) {
                        response($.map(data.data, function (item) {
                            return {
                                name: highlight(item.name, request.term),
                                value: item.name
                            };

                        }));
                    }
                });
            },
            select: function (event, ui) {
                $(event.target).val(ui.item.value);

                var enter = $.Event("keypress");
                enter.which = 13;
                enter.keyCode = 13;
                $(event.target).trigger(enter);

                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
    });
</script>

@if($user->can('article.move') || $site->manager($user, 'article.move'))

    <div class="form-group">
        <label for="section_id">Расположение статьи</label>
        {{ Form::select('section_id', $sections, $section->id, ['class' => 'select-sort', 'id' => 'section_id']) }}
    </div>

@else

    <div class="form-group">
        <label for="a-domain">Расположение статьи</label>
        {{ Form::text('section_title', section_path_format($section), ['class' => 'form-control input-lg', 'id' => 'section_title', 'readonly']) }}
        {{ Form::hidden('section_id', $section->id) }}
    </div>

@endif

@if($formAction == route('section.article.save-edit-form', ['article_slider' => $article->id]) && ($user->can('article.transfer') || $site->manager($user, 'article.transfer')) && !empty($otherSections))

    <div class="form-group">
        <label for="other_section_id">Перенос статьи на другой ресурс</label>
        {{ Form::select('other_section_id', $otherSections, null, ['class' => 'select-sort', 'id' => 'other_section_id']) }}
    </div>
@endif

<div class="form-group">
    <div class="preview-images-upload">
        <div class="btn-upload">
            <input type="file" id="i-upload" class="js-fileupload-cropper" name="image" accept="image/*">

            <label for="i-upload" class="btn btn-primary btn-lg btn-xlg js-fileupload-btn">Выбрать изображение</label>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="cropper-area">
        @if($article->image)
            <img src="{{$article->imageUrl('880x480', 'article_slider')}}" alt="">
        @endif
    </div>
</div>

<div class="form-group">
    <label>Текст записи</label>
    {{ Form::textarea('content', $article->content, ['class' => 'form-control', 'id' => 'content']) }}
</div>

<div class="article-options">
    <div class="form-group row">
        <div class="col-md-12">
            <label class="label-secondary">URL для статьи</label>

            {{ Form::text('slug', $article->slug ? $article->slug : null, ['class' => 'form-control input-lg']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-8">
            <label class="label-secondary">Дата и время публикации</label>

            <div class="input-group date  js-datetimepicker" data-min-date="true">
                {{ Form::text('published_at', $article->published_at ? $article->published_at : null, ['class' => 'form-control input-lg']) }}

                <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <label class="label-secondary">Сортировка комментариев</label>

            <select name="sort_comments">
                <option value="0">По дате</option>
                <option value="1">По популярности</option>
            </select>
        </div>

    </div>


    <div class="form-group">
        <div class="checkbox">
            {{ Form::checkbox('allow_comments', 1, null, ['id' => 'ac', 'checked' => $article->isAllowComments()? true : null]) }}
            <span class="checkbox-control"></span>
            <label for="ac">Разрешить комментарии</label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            {{ Form::checkbox('moderate_comments', 1, null, ['id' => 'mc', 'checked' => $article->isModerateComments()? true : null]) }}
            <span class="checkbox-control"></span>
            <label for="mc">Модерация коментариев</label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">

            {{ Form::checkbox('draft', 1,  $article->isDraft(), ['id' => 'draft']) }}
            <span class="checkbox-control"></span>
            <label for="draft">Черновик</label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            {{ Form::checkbox('vitrina', 1, null, ['id' => 'vitrina', 'checked' => $article->vitrina ? true : null]) }}
            <span class="checkbox-control"></span>
            <label for="vitrina">Витрина</label>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-xlg btn-lg">
                    Сохранить
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" name="filename" class="js-uploaded-file"/>

    @if(Auth::user())
        <input type="hidden" name="token" value="{{Auth::user()->auth_token}}"/>
    @endif

    <input type="hidden" name="c" value="{{request()->cookie('c')}}"/>
