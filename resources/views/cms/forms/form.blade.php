{{ Form::model($form, ['url' => route($action, ['forms' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('field_group_id', 'Группа форм', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('field_group_id',$field_groups, null, ['class' => 'form-control', 'id' => 'field_group_id']) }}
    </div>
</div>

<div class="form-group clearfix" id="fg_field_type">
    {{ Form::label('field_type', 'Тип', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('field_type',$field_types, null, ['class' => 'form-control', 'id' => 'field_type']) }}
    </div>
</div>

@if(!empty($field_values))

    @foreach($field_values as $index => $value)

        <div class="form-group clearfix" data-id="{{$index}}">
            {{ Form::label('field_type', 'Значение', ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-5">
                <input type="text" name="values[{{$index}}][value]" value="{{$value['value']}}" class="form-control"
                       data-id="{{$index}}">
                <input type="text" name="values[{{$index}}][sort_order]" value="{{$value['sort_order']}}" class="form-control"
                       data-id="{{$index}}">
                <input type="hidden" name="values[{{$index}}][id]" value="{{$value['id']}}" class="form-control"
                       data-id="{{$value['id']}}">
            </div>

            <div class="col-sm-5" style="height:34px;padding-top: 9px;">
                <a href="javascript:void(0);" onclick="window.setFieldCounter();" class="add-property"
                   data-id="{{$index}}">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
                <a href="javascript:void(0);" class="remove-property"
                   onclick="window.removeFieldCounter('{{$index}}', this);"
                   data-id="5456">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
    @endforeach

@endif

<div class="form-group clearfix">
    {{ Form::label('name', 'Имя', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('placeholder', 'Placeholder', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('placeholder', null, ['class' => 'form-control', 'id' => 'placeholder']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('required', 'Обязательно для заполнения?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('required', 1, $form->required == 1, ['id' => 'default_value']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

@if($form->id)
    {{Form::hidden('alias')}}
@endif

{{ Form::close() }}