@if(count($sites) > 0)
    @foreach($sites as $site)
        <iframe src="{{getSchema()}}{{$site}}{{getPort()}}/credentials/erase_guest_cookie?u={{$user ? $user->auth_token : null}}"
                frameborder="0"
                width="0"
                height="0"></iframe>
    @endforeach
@endif
@if(!empty($personal))
    <iframe src="{{getSchema()}}{{$personal}}{{getPort()}}/l/{{$user ? encrypt($user->id, false) : null}}"
            frameborder="0"
            width="0"
            height="0"></iframe>
@endif