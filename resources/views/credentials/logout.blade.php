@if(count($sites) > 0)
    @foreach($sites as $site)
        <iframe src="{{getSchema()}}{{$site}}{{getPort()}}/credentials/native_logout"
                frameborder="0"
                width="0"
                height="0"></iframe>
    @endforeach
@endif

@if(count($personal) > 0)
    @foreach($personal as $personalSite)
        <iframe src="{{getSchema()}}{{$personalSite}}{{getPort()}}/credentials/native_logout"
                frameborder="0"
                width="0"
                height="0"></iframe>
    @endforeach
@endif
