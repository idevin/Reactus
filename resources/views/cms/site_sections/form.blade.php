{{ Form::model($form, ['url' => route($action, ['id' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('site_id', 'Сайт', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('site_id', $sites, $form->site_id, ['class' => 'form-control', 'id' => 'site_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('section_id', 'Раздел', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('section_id', [null => 'Выберите раздел...'] + $sections, $form->section_id,['class' => 'form-control', 'id' => 'section_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('template_id', 'Шаблон', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('template_id', $templates, $form->template_id, ['class' => 'form-control', 'id' => 'template_id']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('active', 'Активный перенос?') }}
    {{ Form::checkbox('active', 1, $form->active == 1 ? true : false, ['id' => 'active']) }}
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}