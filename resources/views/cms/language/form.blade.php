{{ Form::model($form, ['url' => route($action, ['id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('title', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('alias', 'Псевдоним', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('alias', null, ['class' => 'form-control', 'id' => 'alias']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('priority', 'Приоритет', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('priority', null, ['class' => 'form-control', 'id' => 'priority', 'type' => 'number']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}