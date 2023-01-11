{{ Form::model($form, ['url' => route($action, ['id' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('field_group_id', 'Группа полей', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('field_group_id', [null => 'Выберите группу...'] + $field_groups, $form->fieldGroup?->id, ['id' => 'object_field_group_id', 'class' => 'form-control select']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('catalog_id', 'Прикрепить к каталогу', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('catalog_id', [null => 'Выберите каталог...'] + $allNodes, null, ['id' => 'node_id', 'class' => 'form-control select']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}