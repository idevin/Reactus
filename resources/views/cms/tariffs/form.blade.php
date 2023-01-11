{{ Form::model($form, ['url' => route($action, ['tariff_id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::textarea('description', $form->description, ['class' => 'form-control', 'id' => 'content']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Сервисы', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('services[]', $services, $form->services, ['class' => 'form-control', 'multiple' => 'multiple']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Окончание тарифа', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::datetime('end_date', $form->end_date, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'end_date']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}

@section('scripts')
    <script>
        $(function () {

            $('#end_date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true
            });
        })
    </script>
@endsection