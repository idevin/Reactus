{{ Form::model($form, ['url' => route($action, ['permissions' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}


@if(!$form->id)
    <div class="form-group clearfix">
        {{ Form::label('name', 'Псеводним', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::text('name', $form->name, ['class' => 'form-control']) }}
        </div>
    </div>
@else
    <div class="form-group clearfix">
        {{ Form::label('name', 'Псеводним', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{$form->name}}
            {{ Form::hidden('name', $form->name) }}
        </div>
    </div>
@endif

<div class="form-group clearfix">
    {{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('description', $form->description, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('description', 'Аннотация', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::textarea('annotation', $form->annotation, ['class' => 'form-control']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}