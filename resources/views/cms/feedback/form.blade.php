<?php

$siteSelect = Form::select('site_id', [null => 'Выберите сайт...'] + $sites, $siteId, array('id' => 'site_id', 'class' => 'form-control'));

?>
{{ Form::model($form, ['url' => route($action, ['feedback' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('site', 'Сайт', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
            {{$siteSelect}}
    </div>
</div>

@if(!empty($fieldGroups))
    <div class="form-group clearfix">
        {{ Form::label('fields', 'Поля', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            @foreach($fieldGroups as $index => $fieldGroup)
                <h3>{{$fieldGroup['group']->name}}</h3>

                @foreach($fieldGroup['fields'] as $field)
                    {{ Form::checkbox('field_id[]', $field->id, isset($field->checked), ['class' => 'control-label required']) }}    {{$field->name}}
                    <input type="text" style="width: 50px;" name="field_sort[{{$field->id}}]" value="{{isset($field->sort_order) ? $field->sort_order : 0}}">
                @endforeach
            @endforeach
        </div>
    </div>
@else
    @if(!request('site_id'))

    @else
        <div align="center">Полей для домена не найдено...</div>
    @endif

@endif
<br>
<div class="row btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}