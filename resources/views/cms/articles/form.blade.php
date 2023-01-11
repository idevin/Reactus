{{ Form::model($form, ['url' => route($action, ['articles' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('site', 'Сайт', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('site_id', [null => 'Выберите сайт...'] + $sites,  $form->site_id, ['id' => 'site', 'class' => 'form-control', 'data-section-options-url'=> route('articles.changeSection')]) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('section_id', 'Раздел', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('section_id', [null => 'Выберите раздел...'] + $sections, $form->section_id, array('id' => 'div_section', 'class' => 'form-control')) }}
    </div>

</div>

<div class="form-group clearfix">
    {{ Form::label('auto_author_username', 'Автор', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        <span>
        {{ Form::text('author_username', username($form->author), array('id' => 'author_username', 'class' => 'form-control autocomplete')) }}
            <input id="author_id" name="author_id" type="hidden" value="{{$form->author_id}}">
        </span>
    </div>
</div>


<div class="form-group clearfix">
    {{ Form::label('title', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', $form->title, array('id' => 'title', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('content', 'Контент', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::textarea('content', $form->content, array('id' => 'content', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('status', 'Статус', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('status', $statusOptions, $form->status, array('id' => 'title', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('slug', 'Название ссылки', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('slug', $form->slug, array('id' => 'slug', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix" id="fg_image">
    <label for="image" class="col-sm-2 control-label">Картинка</label>
    <div class="col-sm-10" id="div_image">
        <input class="form-control form-control" type="file" id="image" name="image">
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('published_at', 'Дата публикации', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10" id="div_published_at">
        {{ Form::text('published_at', $form->published_at, array('id' => 'published_at', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('unpublished_at', 'Дата снятия с публикации', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10" id="div_unpublished_at">
        {{ Form::text('unpublished_at', (strtotime($form->unpublished_at) < 0 ? '' : $form->unpublished_at), array('id' => 'unpublished_at', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('active', 'Активная статья?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('active', 1, (bool)$form->active, array('id' => 'active')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('settings[allow_comments]', 'Разрешить коментарии?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('settings[allow_comments]', 1, (isset($form->settings['allow_comments']) ? (bool)$form->settings['allow_comments'] : 0)) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('settings[moderate_comments]', 'Модерация коментариев?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('settings[moderate_comments]', 1, (isset($form->settings['moderate_comments']) ? (bool)$form->settings['moderate_comments'] : 0)) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}

@section('scripts')
    <script>

        $(function () {

            $("#author_username").autocomplete({
                type: 'POST',
                dataType: 'JSON',
                serviceUrl: "{{route('articles.searchAuthor')}}",
                minLength: 2,
                onSelect: function (data) {
                    $('#author_id').val(data.data);
                }
            });
        });

    </script>

    <script>
        $(function () {

            $('#published_at').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true
            });

            $('#unpublished_at').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true
            });

            $('#site').change(function () {

                var url = $(this).data('section-options-url');

                $.post(url,
                    {
                        site_id: $(this).val()
                    },
                    function (data) {
                        $("#div_section").html(data);
                    }
                )
            });
        })
    </script>
@endsection
