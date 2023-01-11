<div class="profile-section-action pull-right"
     data-group_id="-1">

    <div class="dropdown profile-visibility">
        <button type="button"
                class="btn btn-link  @if(isset($user->visibility)) {{config('netgamer.group_visibility')[$user->visibility]['css']}}@else {{config('netgamer.group_visibility')[config('netgamer.default_group_visibility')]['css']}}@endif profile-visibility-toggle"
                data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

            @if(isset($user->visibility))
                {{config('netgamer.group_visibility')[$user->visibility]['name']}}
            @else
                {{config('netgamer.group_visibility')[config('netgamer.default_group_visibility')]['name']}}
            @endif

        </button>

        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu js-profile-visibility"
            aria-labelledby="dLabel">

            @foreach(config('netgamer.group_visibility') as $index => $arrayValue)
                <li class="profile-visibility-menu-item"
                    data-visibility="{{$index}}"
                    data-multi_field="0"
                    data-group_id="-1">
                    <button type="button" class="btn btn-link {{$arrayValue['css']}}">{{$arrayValue['name']}}</button>
                </li>
            @endforeach

        </ul>
    </div>
</div>