{{ Form::model($form, ['url' => route($action, ['service_options' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'novalidate' => 'novalidate']) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('billing_service_id', 'Сервис', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('billing_service_id', [null => 'Выберите сервис...'] + $services->toArray(), null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('increment_type', 'Тип', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('increment_type', [null => 'Выберите тип...'] + $types, null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('price_label', 'Цена', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('price', $form->price, ['class' => 'form-control', 'step' => 0.01, 'min' => 0]) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}