@if($field->field_type == 0)

    <input data-field_group_id="{{$group['group']->id}}"
           data-id="{{$field->id}}"
           name="{{$field->alias}}"
           type="text"

           @if($field->required == 1)
           required="required"
           @endif

           placeholder="{{$field->default_value}}"
           value="@if($group['group']->multi_field == 0){{$field->value['value']}}@endif"
           class="form-control input-lg">
@endif

@if($field->field_type == 3)
    <input data-field_group_id="{{$group['group']->id}}"
           data-id="{{$field->id}}"
           name="{{$field->alias}}"

           @if($field->required == 1)
           required="required"
           @endif

           type="checkbox"
           @if(!empty($field->value['value']))checked="checked" @endif
           value="@if($group['group']->multi_field == 0){{1}}@endif">
@endif

@if($field->field_type == 4)
    <select name="{{$field->alias}}" data-id="{{$field->id}}" id="select_{{$field->id}}" data-field_group_id="{{$group['group']->id}}">
        <option value="" @if(empty($field->value['value']))selected="selected"@endif>Выберите из списка...</option>

        @if(!empty($field->field_values))
            @foreach($field->field_values as $value)
                <option value="{{$value['value']}}"
                        data-option_id="{{$value->id}}"
                        @if($field->value['value'] == $value['value'] && $group['group']->multi_field == 0)selected="selected"@endif>
                    {{$value['value']}}
                </option>
            @endforeach
        @endif
    </select>
@endif

@if($field->field_type == 5)
    <input data-field_group_id="{{$group['group']->id}}"
           data-id="{{$field->id}}"
           name="{{$field->alias}}"
           type="text"

           @if($field->required == 1)
           required="required"
           @endif

           value="@if($group['group']->multi_field == 0){{$field->value['value']}}@endif"
           class="form-control input-lg has-city-autocomplete">
@endif

@if($field->field_type == 6)

    <div class="file" data-alias="{{$field->alias}}">

        @if($field->value['file'])
            <a target="_blank" href="{{route('storage.download', ['id' => $field->value['file']->id])}}">{{$field->value['file']->filename}}
                .{{$field->value['file']->extension}}</a>
        @endif
    </div>
    <input data-field_group_id="{{$group['group']->id}}"
           data-id="{{$field->id}}"
           name="{{$field->alias}}"

           @if($field->required == 1)
           required="required"
           @endif

           type="file"
           value="@if($group['group']->multi_field == 0){{$field->value['value']}}@endif"
           class="form-control input-lg">
@endif