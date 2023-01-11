{{ Form::model($form, ['url' => route($action, ['objects' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required', 'maxlength' => '100']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, array('id' => 'name', 'class' => 'form-control')) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}