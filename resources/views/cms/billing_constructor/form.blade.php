{{ Form::model($form, ['url' => route($action, ['constructor' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'novalidate' => 'novalidate']) }}

<div class="form-group clearfix">
    {{ Form::label('tariff', 'Тариф', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('billing_tariff_id', [null => 'Выберите тариф...'] + $tariffs, null,
        ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('service', 'Сервис', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('billing_service_id', [null => 'Выберите сервис...'] + $services, null,
        ['class' => 'form-control']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}