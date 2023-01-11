@if(request('ord'))
    @if(preg_replace('#[^a-z_]#', '', request('ord')) != $alias)
        <a href="{{route($route)}}?{{queryFilter($alias)}}"><span class="glyphicon glyphicon-chevron-up"></span></a>
        <a href="{{route($route)}}?{{queryFilter($alias, true)}}">
            <span class="glyphicon glyphicon-chevron-down"></span>
        </a>
    @else

        @if(strstr(request('ord'), '-'))
            <a href="{{route($route)}}?{{queryFilter($alias)}}"><span class="glyphicon glyphicon-chevron-up"></span></a>
            <span class="glyphicon glyphicon-chevron-down"></span>
        @else
            <span class="glyphicon glyphicon-chevron-up"></span>
            <a href="{{route($route)}}?{{queryFilter($alias, true)}}"><span
                        class="glyphicon glyphicon-chevron-down"></span></a>
        @endif
    @endif

@else

    <a href="{{route($route)}}?{{queryFilter($alias)}}"><span class="glyphicon glyphicon-chevron-up"></span></a>
    <a href="{{route($route)}}?{{queryFilter($alias, true)}}"><span class="glyphicon glyphicon-chevron-down"></span></a>

@endif

{{$name}}