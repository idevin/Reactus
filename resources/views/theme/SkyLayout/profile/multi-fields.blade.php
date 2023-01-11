@foreach($fieldUserGroups as $fieldUserGroup)
    @if($group['group']->id == $fieldUserGroup->field_group_id)
        <div class="profile-fields" data-id="{{$fieldUserGroup->id}}">
            <div class="row">
                <div class="col-sm-9">
                    @foreach($fieldUserGroup->field_user_values()->get() as $fieldValue)

                    @if(!empty($fieldValue->value))
                    {{$fieldValue->field->name}} &mdash; {{$fieldValue->value}}
                    @endif
                    @endforeach
                </div>

                <div class="col-sm-2">
                    <a href="#" class="delete_multi_field" data-id="{{$fieldUserGroup->id}}">удалить</a>
                </div>
            </div>
            <hr>
        </div>
    @endif
@endforeach