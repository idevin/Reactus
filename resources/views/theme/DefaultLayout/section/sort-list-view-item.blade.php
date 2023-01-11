<li data-id="{{$section->id}}" class="list-items" data-view="list" style="list-style-type: none; clear: both; display: block;z-index: 100000;">
    <div class="list-item" style="min-height:auto;">
        <div class="list-item-params">
            <span class="list-item-rating rating rating-gray">{{$section->rating}}</span>
            <p class="list-item-param hidden-xs text-muted">
                <span class="icon icon-communities"></span> {{$section->articles_cnt}}
            </p>
        </div>

        <div class="list-item-desc" style="padding-bottom: 9px;">
            {!! $section->title !!}
        </div>

        @if(count($section->children) > 0)
            <a href="#" class="list-item-dropdown-toggle" data-dropdown-toggle="sections_list-item-{{$section->id}}"></a>
        @endif

        @if(count($section->children) > 0)
            <div class="list-item-dropdown clearfix" data-dropdown="sections_list-item-{{$section->id}}">
                @if(array_chunk($section->children->toArray(), 3))
                    @foreach(array_chunk($section->children->toArray(), 3) as $index => $children)
                        <div class="col-xs-12">
                            @foreach($children as $child)
                                <div class="col-md-4">
                                    <a href="{{route_to_section($child)}}" style="text-indent: 0;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: block;
    overflow: hidden;">
                                    <span class="list-item-rating rating rating-white" style="padding-left: 0;
    left: 0;
    width: 20px;
    height: 20px;
    font-size: 9px;
    line-height: 18px;
    margin-top: 3px;
    margin-right: 10px;">{{rating_format($child['rating'])}}</span>
                                        {{$child['title']}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="col-xs-12">
                        @foreach($section->children as $child)
                            <div class="col-md-4">
                                {{--<a href="{{route_to_section($child)}}">--}}
                                <span class="icon icon-comments-light"></span>
                                {{$child->title}}
                                {{--</a>--}}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</li>