{{ Form::model($form, ['url' => route($action, ['form_groups' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('parent_id', 'Добавить в группу', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('parent_id', \App\Models\FieldGroup::getTree(true, true), $form->parent_id, array('id' => 'parent_id', 'class' => 'form-control select')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('for_module', 'Для модуля?', ['class' => 'col-sm-2 control-label']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('for_module', 1, null, ['id' => 'for_module']) }}
    </div>
</div>

@if($form->id != config('netgamer.user_field_group'))
    <div class="form-group clearfix" id="fg_field_type">
        {{ Form::label('multi_field', 'Мульти поля?', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::checkbox('multi_field',1, null, ['id' => 'multi_field']) }}
        </div>
    </div>
@endif

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

@if($form->id)
@endif

{{ Form::close() }}