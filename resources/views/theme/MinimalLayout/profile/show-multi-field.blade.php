@foreach($fieldUserGroups as $fieldUserGroup)
    @if($group['group']->id == $fieldUserGroup->field_group_id)
        @if($fieldUserGroup->visibility != 2)
            <div class="profile-fields" data-id="{{$fieldUserGroup->id}}">
                <div class="row">
                    <div class="col-sm-9">
                        @foreach($fieldUserGroup->field_user_values()->get() as $fieldValue)

                            @if(!empty($fieldValue->value))
                                <div>
                                    {{$fieldValue->field->name}} &mdash; {{$fieldValue->value}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
            </div>
        @endif
    @endif
@endforeach