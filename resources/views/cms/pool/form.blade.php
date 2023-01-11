{{ Form::model($form, ['url' => route($action, ['id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('alias', 'Alias', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('alias', null, ['class' => 'form-control', 'id' => 'alias']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('default', 'Шаблон по умолчанию', ['class' => '']) }}
    {{ Form::checkbox('default', 1, (boolval($template->default == 1)) ,['class' => '', 'id' => 'default']) }}
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}