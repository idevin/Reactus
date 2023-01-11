{{ Form::model($form, ['url' => route($action, ['id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('user_id', 'Пользователь', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('user_id[]', $users, $form->user_id, ['class' => 'form-control', 'id' => 'user_id', 'multiple' => true]) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('role_id', 'Роль', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('role_id[]', $roles, $form->roles()->pluck('role_id')->toArray(),['class' => 'form-control', 'id' => 'role_id', 'multiple' => true]) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('section_id', 'Раздел', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('section_id', $sections, $form->section_id, ['class' => 'form-control', 'id' => 'section_id']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}