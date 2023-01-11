{{
Form::model($form, ['url' => route($action, ['object_fields' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical'])
}}

<div class="form-group clearfix">
    {{ Form::label('field_group_id', 'Группа форм', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">

        {{ Form::select('field_group_id', [null => 'Выберите группу...'] + $field_groups, $form->fieldGroup?->id , ['class' => 'form-control', 'id' => 'object_field_group_id']) }}
    </div>
</div>

<div class="form-group clearfix" id="fg_field_type">
    {{ Form::label('field_type', 'Тип', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">

        {{ Form::select('field_type', ([null => 'Выберите тип...'] + $field_types), $form->field_type, ['class' => 'form-control', 'id' => 'object_field_type']) }}
    </div>
</div>

@php
    if(isset($oldInput['field_type']) && ($oldInput['field_type'] == \App\Models\NeoCatalogField::FIELD_TYPE_RANGE)
|| !empty($nodes) || $form->field_type == \App\Models\NeoCatalogField::FIELD_TYPE_RANGE) {
$display = 'block';
    } else {
$display = 'none';
    }
@endphp


<div class="form-group clearfix" id="fg_values" style="display:{{$display}};">

    {{ Form::label('data_node_id', 'Значения', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-3">
        @php
            $rangeValue2 = $rangeValue1 = $rangeValue0 = null;
                if(count($field_values) > 0 && $form->field_type ==  \App\Models\NeoCatalogField::FIELD_TYPE_RANGE) {

        $rangeValue2 = $form->values[2]['value'];
        $rangeValue1 = $form->values[1]['value'];
         $rangeValue0 = $form->values[0]['value'];
        }
        @endphp

        {{ Form::number('values[][value]', $rangeValue2, ['class' => 'form-control', 'placeholder' => 'Минимальное значение', 'step'=>"0.01"]) }}
    </div>
    <div class="col-sm-3">

        {{ Form::number('values[][value]',  $rangeValue1, ['class' => 'form-control', 'placeholder' => 'Максимальное значение', 'step'=>"0.01"]) }}
    </div>
    <div class="col-sm-3">
        {{ Form::number('values[][value]', $rangeValue0, ['class' => 'form-control', 'placeholder' => 'Шаг', 'step'=>"0.01"]) }}
    </div>
</div>

@if(!empty($field_values) && $form->field_type &&
in_array($form->field_type, [\App\Models\NeoCatalogField::FIELD_TYPE_SELECT,
\App\Models\NeoCatalogField::FIELD_TYPE_RADIO, \App\Models\NeoCatalogField::FIELD_TYPE_MULTISELECT]))

    @foreach($field_values as $index => $value)
        <div class="form-group clearfix" data-id="{{$value['id']}}">
            {{ Form::label('field_type', 'Значение и №', ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-5">
                <input type="text" name="values[{{$value['id']}}][value]" value="{{$value['value']}}"
                       class="form-control"
                       data-id="{{$value['id']}}">
                <input type="text" name="values[{{$value['id']}}][sort_order]" value="{{$value['sort_order']}}"
                       class="form-control"
                       data-id="{{$value['id']}}">
                <input type="hidden" name="values[{{$value['id']}}][id]" value="{{$value['id']}}" class="form-control"
                       data-id="{{$value['id']}}">
            </div>

            <div class="col-sm-5" style="height:34px;padding-top: 9px;">
                <a href="javascript:void(0);" onclick="window.setFieldCounter();" class="add-property"
                   data-id="{{$value['id']}}">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
                <a href="javascript:void(0);" class="remove-property"
                   onclick="window.removeFieldCounter('{{$value['id']}}', this);"
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
    {{ Form::label('sort_order', 'Номер по порядку', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::number('sort_order', $form->sort_order, ['class' => 'form-control', 'id' => 'sort_order']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('placeholder', 'Placeholder', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('placeholder', null, ['class' => 'form-control', 'id' => 'placeholder']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('alias', 'Alias', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('alias', null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('required', 'Обязательно для заполнения?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('required', 1, $form->required == 1) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('use_in_filter', 'Использовать в фильтре?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('use_in_filter', 1, $form->use_in_filter == 1) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('use_in_catalog_list', 'Использовать в списке каталога?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('use_in_catalog_list', 1, ($form->use_in_catalog_list == 1 ? true : false)) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}


@section('scripts')
    <script>
        $(function () {
            window.addAfter = $('#fg_field_type');

            window.objectFieldGraph = [
                {{\App\Models\NeoCatalogField::FIELD_TYPE_MULTISELECT}},
                {{\App\Models\NeoCatalogField::FIELD_TYPE_SELECT}},
                {{\App\Models\NeoCatalogField::FIELD_TYPE_RADIO}}
            ];

            window.range = {{\App\Models\NeoCatalogField::FIELD_TYPE_RANGE}};
            window.card_select = {{\App\Models\NeoCatalogField::FIELD_TYPE_CARD_SELECT}};
            $(document).on('change', '#object_field_type', function () {
                let val = parseInt($(this).val());
                let nodeId = $('#fg_data_node_id');
                let values = $('#fg_values');
                let cardId = $('#fg_data_card_id')
                let selectValues = $('.form-group[data-id]');

                nodeId.hide();
                values.hide();
                cardId.hide();
                selectValues.remove();

                if ($.inArray(val, window.objectFieldGraph) > -1) {
                    window.setFieldCounter();

                } else if (val === window.range) {
                    values.show();
                } else if (val === window.card_select) {
                    cardId.show();
                }
            });
        });
    </script>
@endsection