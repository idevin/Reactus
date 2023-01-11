{{ Form::model($form, ['url' => $action, 'theme' => 'bootstrap-vertical', 'method' => 'post']) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название валюты', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, array('id' => 'name', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('iso_code', 'ISO код', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('iso_code', $codes, $form->iso_code, array('id' => 'iso_code', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('points_value', 'Значение в поинтах', ['class' => 'col-sm-2 control-label required', ]) }}

    <div class="col-sm-10">
        {{ Form::number('points_value', $form->points_value, array('id' => 'points_value', 'class' => 'form-control','step' => '0.01')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('currency_value', 'Значение в валюте', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('currency_value', 1, array('id' => 'currency_value', 'class' => 'form-control', 'readonly')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('is_default', 'По умолчанию?', ['class' => 'col-sm-2 control-label']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('is_default', 1, null, ['id' => 'is_default']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}