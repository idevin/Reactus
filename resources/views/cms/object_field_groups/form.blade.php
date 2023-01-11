{{ Form::model($form, ['url' => route($action, ['object_field_groups' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('title', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('description', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('sort_order', 'Номер по порядку', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('sort_order', null, ['class' => 'form-control', 'id' => 'sort']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}