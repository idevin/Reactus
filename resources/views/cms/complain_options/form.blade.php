{{ Form::model($form, ['url' => route($action, ['complain_options' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'class' => 'form-horizontal']) }}

<div class="form-group clearfix">
    {{ Form::label('parent', 'Родитель', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('parent', $treeOptions, $form->parent_id, ['class' => 'form-control', 'id' => 'parent']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('title', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', $form->title, ['class' => 'form-control', 'id' => 'domain']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('value', 'Значение для кармы', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('value', $form->value, ['class' => 'form-control', 'id' => 'value']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}