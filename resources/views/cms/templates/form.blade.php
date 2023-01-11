{{ Form::model($form, ['url' => route($action, ['templates' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('alias', 'Alias', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('alias', null, ['class' => 'form-control', 'id' => 'alias', ] + (isset($create) ? [] : ['disabled' => true])) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('default', 'Шаблон по умолчанию', ['class' => '']) }}
    {{ Form::checkbox('default', 1, $form->default == 1 ,['class' => '', 'id' => 'default']) }}
</div>

<div class="form-group">
    {{ Form::label('hidden', 'Скрыть ?', ['class' => '']) }}
    {{ Form::checkbox('hidden', 1, $form->hidden == 1 ,['class' => '', 'id' => 'hidden']) }}
</div>

<div class="form-group">
    {{ Form::label('hidden', 'Платный ?', ['class' => '']) }}
    {{ Form::checkbox('template_type', 1, $form->template_type == \App\Models\Template::TYPE_PAID ,['class' => '', 'id' => 'hidden']) }}
</div>

@if(!empty($templateSchemes))
    <hr>

    <div class="form-group">
        @foreach($templateSchemes as $scheme)
            {{ Form::label('scheme_' . $scheme->id, $scheme->name) }}
            {{ Form::checkbox('template_scheme_id[]', $scheme->id, in_array($scheme->id, $templateSchemeArray) ,['class' => '', 'id' =>
             'template_scheme_id_' . $scheme->id]) }} &nbsp; / &nbsp;
        @endforeach
    </div>
@endif

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}