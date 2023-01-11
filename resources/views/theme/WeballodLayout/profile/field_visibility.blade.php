<div class="profile-field-visibility pull-right" @if(isset($fieldAlias))data-field-alias="{{$fieldAlias}}"@endif>
    <div class="dropdown profile-visibility">
        <button type="button"
                class="btn btn-link @if(isset($field) && isset($field->value['visibility'])){{config('netgamer.field_visibility')[$field->value['visibility']]['css']}}@else{{config('netgamer.field_visibility')[config('netgamer.default_field_visibility')]['css']}}@endif field-visibility-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                data-id="@if(isset($field)){{$field->id}}@endif"
                aria-expanded="false">

            @if(isset($field) && isset($field->value['visibility']))
                {{config('netgamer.field_visibility')[$field->value['visibility']]['name']}}
            @else
                {{config('netgamer.field_visibility')[config('netgamer.default_field_visibility')]['name']}}
            @endif

        </button>

        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu js-profile-visibility"
            aria-labelledby="dLabel">

            @if(isset($field))
                @set('groupId', $field->field_group_id)
            @else
                @set('groupId', -1)
            @endif

            @foreach(config('netgamer.field_visibility') as $index => $arrayValue)
                <li class="field-visibility-menu-item"
                    data-visibility="{{$index}}"
                    data-group_id="{{$groupId}}"
                    data-field_alias="{{$fieldAlias}}"
                    data-id="@if(isset($field)){{$field->id}}@endif">
                    <button type="button" class="btn btn-link {{$arrayValue['css']}}">{{$arrayValue['name']}}</button>
                </li>
            @endforeach
        </ul>
    </div>
</div>