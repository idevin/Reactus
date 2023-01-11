{{ Form::model($form, ['url' => route($action, ['sites' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'class' => 'form-horizontal']) }}

@if($form && $form->parent_id != null)
    <div class="form-group clearfix">
        {{ Form::label('parent', 'Родитель', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::select('parent', $treeOptions, $form->parent_id, ['class' => 'form-control', 'id' => 'parent']) }}
        </div>
    </div>
@endif

<div class="form-group clearfix">
    {{ Form::label('domain', 'Домен', ['class' => 'col-sm-2 control-label required']) }}
    @if(!empty($domains))
        <div class="col-sm-10">
            {{ Form::select('domain', $domains, $form->domain, ['class' => 'form-control', 'id' => 'domain']) }}
        </div>
    @else
        <div class="col-sm-10">
            {{ Form::text('domain', $form->domain, ['class' => 'form-control', 'id' => 'domain']) }}
        </div>
    @endif
</div>


<div class="form-group clearfix">
    {{ Form::label('title', 'Заголовок', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', $form->title, ['class' => 'form-control', 'id' => 'title']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('slogan', 'Слоган', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('slogan', $form->slogan, ['class' => 'form-control', 'id' => 'slogan']) }}
    </div>
</div>

<hr>

<div class="form-group clearfix">
    {{ Form::label('content', 'Описание', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::textarea('content', $form->content, ['class' => 'form-control', 'id' => 'content']) }}
    </div>
</div>

<hr>

<div class="form-group clearfix">
    {{ Form::label('user_id', 'Пользователь', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('user_id', $users, $form->user_id, ['class' => 'form-control', 'id' => 'user_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('template_id', 'Шаблон', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('template_id', $templatesSelect, $form->template_id, ['class' => 'form-control', 'id' => 'template_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('template_scheme_id', 'Цветовая схема', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('template_scheme_id', $templateSchemes, $form->template_scheme_id, ['class' => 'form-control', 'id' => 'template_scheme_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('show_article_rating', 'Показывать рейтинг в статье', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('show_article_rating', 1, (bool)$form->show_article_rating, ['id' => 'show_article_rating']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('show_article_author', 'Показывать автора в списке статей', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('show_article_author', 1, (bool)$form->show_article_author, ['id' => 'show_article_author']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('show_section_rating', 'Показывать рейтинг разделов', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('show_section_rating', 1, (bool)$form->show_section_rating, ['id' => 'show_section_rating']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('hide_article_author_inside', 'Скрывать автора в статье', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('hide_article_author_inside', 1, (bool)$form->hide_article_author_inside,
        ['id' => 'hide_article_author_inside']) }}
    </div>
</div>

{{--<hr>--}}

{{--<div class="form-group clearfix" id="fg_favicon">--}}
{{--<label for="favicon" class="col-sm-2 control-label">Favicon</label>--}}
{{--<div class="col-sm-10" id="div_favicon">--}}

{{--@if(!empty($form->favicon))--}}
{{--<div class="clearfix"><a href="{{$form->faviconUrl()}}"--}}
{{--target="_blank">--}}
{{--<img width="100" src="{{$form->faviconUrl()}}" class="pull-left"--}}
{{--style="margin:0 10px 10px 0;"></a>--}}
{{--<br>--}}
{{--<input name="favicon_remove" type="checkbox" value="1"> Удалить <br>--}}
{{--</div>--}}
{{--@endif--}}

{{--<input class="form-control form-control" type="file" id="favicon" name="favicon">--}}
{{--</div>--}}
{{--</div>--}}

{{--<hr>--}}

{{--<div class="form-group clearfix" id="fg_logo">--}}

{{--<label for="logo" class="col-sm-2 control-label">Лого</label>--}}
{{--<div class="col-sm-10" id="div_logo">--}}

{{--@if(!empty($form->logo))--}}
{{--<div class="clearfix"><a href="{{$form->originalLogo()['thumbs']['thumb280x157']}}"--}}
{{--target="_blank">--}}
{{--<img width="100" src="{{$form->logoUrl()}}" class="pull-left"--}}
{{--style="margin:0 10px 10px 0;"></a>--}}
{{--<br>--}}
{{--<input name="logo_remove" type="checkbox" value="1"> Удалить <br>--}}
{{--</div>--}}
{{--@endif--}}

{{--<input class="form-control form-control" type="file" id="logo" name="logo">--}}
{{--</div>--}}
{{--</div>--}}

{{--<hr>--}}

{{--<div class="form-group clearfix" id="fg_image">--}}

{{--<label for="logo" class="col-sm-2 control-label">Основное изображение</label>--}}
{{--<div class="col-sm-10" id="div_image">--}}

{{--@if(!empty($form->image))--}}

{{--<div class="clearfix"><a href="{{$form->originalImage()}}"--}}
{{--target="_blank">--}}
{{--<img width="100" src="{{$form->thumbs['thumb70x70']}}" class="pull-left"--}}
{{--style="margin:0 10px 10px 0;"></a>--}}
{{--<br>--}}
{{--<input name="image_remove" type="checkbox" value="1"> Удалить <br>--}}
{{--</div>--}}
{{--@endif--}}

{{--<input class="form-control form-control" type="file" id="image" name="image">--}}
{{--</div>--}}
{{--</div>--}}

{{--<hr>--}}

{{--<div class="form-group clearfix" id="fg_header_home">--}}

{{--<label for="logo" class="col-sm-2 control-label">Изображение в шапке</label>--}}
{{--<div class="col-sm-10" id="div_image">--}}

{{--@if(!empty($form->site_header))--}}
{{--<div class="clearfix"><a href="{{$form->originalSiteHeader()}}"--}}
{{--target="_blank">--}}
{{--<img width="100" src="{{$form->siteHeaderPreview()}}" class="pull-left"--}}
{{--style="margin:0 10px 10px 0;"></a>--}}
{{--<br>--}}
{{--<input name="site_header_remove" type="checkbox" value="1"> Удалить <br>--}}
{{--</div>--}}
{{--@endif--}}

{{--<input class="form-control form-control" type="file" id="site_header" name="site_header">--}}
{{--</div>--}}
{{--</div>--}}

<hr>

<div class="form-group clearfix">
    {{ Form::label('archive', 'В архив?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('archive', 1, ((int)$form->archive == 1 ? true : false), ['id' => 'archive']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}