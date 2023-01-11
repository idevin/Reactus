{{ Form::model($form, ['url' => route($action, ['services' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('currency_id', 'Валюта', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('currency_id', $codes, $form->iso_code, array('id' => 'iso_code', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('amount', 'Кол-во поинтов', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('amount', $form->price, ['class' => 'form-control', 'id' => 'price', 'min' => "1", 'placeholder' => 'Цена']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('percent', 'Процент', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('percent', $form->price, ['class' => 'form-control', 'id' => 'price', 'min' => "0.0", 'placeholder' => 'Процент']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}