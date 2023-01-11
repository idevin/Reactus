<div class="profile-section-action pull-right"
     data-group_id="@if(isset($group)){{$group->id}}@endif">

    <div class="dropdown profile-visibility">
        <button type="button"
                class="btn btn-link @if(isset($userGroup)) {{config('netgamer.group_visibility')[$userGroup->visibility]['css']}}@else {{config('netgamer.group_visibility')[config('netgamer.default_group_visibility')]['css']}} @endif profile-visibility-toggle"
                data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

            @if(isset($userGroup))
                {{config('netgamer.group_visibility')[$userGroup->visibility]['name']}}
            @else
                {{config('netgamer.group_visibility')[config('netgamer.default_group_visibility')]['name']}}
            @endif

        </button>

        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
            aria-labelledby="dLabel">

            @foreach(config('netgamer.group_visibility') as $index => $arrayValue)
                <li class="profile-visibility-menu-item"
                    data-visibility="{{$index}}"
                    data-group_id="@if(isset($group) && isset($group->id)){{$group->id}}@endif"
                    data-multi_field="@if(isset($group)){{$group->multi_field}}@endif">
                    <button type="button" class="save-abstract-form btn btn-link {{$arrayValue['css']}}">{{$arrayValue['name']}}</button>
                </li>
            @endforeach

        </ul>
    </div>
</div>