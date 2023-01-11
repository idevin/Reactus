{{ Form::model($form, ['url' => route($action, ['id' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('site_id', 'Перенос в домен', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('site_id',[null => 'Выберите домен...'] +  $sites, $form->site_id, ['class' => 'form-control', 'id' => 'site_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('section_id', 'Раздел', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('section_id',[null => 'Выберите раздел...'] +  $sections, $form->section_id,['class' => 'form-control', 'id' => 'section_id']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('announce', 'Оставить анонс?') }}
    {{ Form::checkbox('announce', 1, $form->announce == 1, ['id' => 'announce']) }}
</div>

<div class="form-group">
    {{ Form::label('moderated', 'Премодерирован?') }}
    {{ Form::checkbox('moderated', 1, $form->moderated == 1, ['id' => 'moderated']) }}
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}