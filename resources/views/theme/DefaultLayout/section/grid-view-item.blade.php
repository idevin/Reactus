<div class="col-sm-6 col-lg-4">
    <div class="grid-item over" @if((int)$section->is_secret == 1) style="opacity: 0.2;" @endif>
        <a href="@if((int)$section->is_secret == 1){{route_to_hidden_section($section)}}@else{{route_to_section($section)}}@endif"
           class="grid-item-image">
            @if(!empty($section->thumbs))
                <picture>
                    <img src="{{$section->thumbs['thumb280x157']}}" style="margin-top: -25px;">
                </picture>
            @endif

            @if(($section->sectionSetting && (int)$section->sectionSetting->show_rating == 1) || !$section->sectionSetting)
                <span class="grid-item-rating rating rating-white">{{$section->rating}}</span>
            @endif
        </a>

        <div class="grid-item-desc">

            <p class="grid-item-date">
                <small>{{getFormatedDate($section->created_at)}}</small>
            </p>

            <a href="@if((int)$section->is_secret == 1){{route_to_hidden_section($section)}}@else{{route_to_section($section)}}@endif"
               class="grid-item-title">
                <strong>{{$section->title}}</strong>
            </a>

            <div class="item-params">
                @if(count($section->children) > 0)
                    <a href="#" class="grid-item-dropdown-toggle"
                       data-dropdown-toggle="sections_list-item-{{$section->id}}"></a>
                @endif

                @if(count($section->tags) > 0)
                    <div class="item-param item-param-block text-muted" style="white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;">
                        <span class="icon icon-tags"></span>
                        @foreach($section->tags as $tag)
                            @if($tag)
                                <small><a href="#" style="color: rgba(21,26,33,0.5);">{{$tag->name}}</a></small>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="item-param">
                    <span class="icon icon-communities"></span>
                    <small>{{$section->articles_cnt}}</small>
                </div>
                <div class="item-param">
                    <span class="icon icon-views"></span>
                    <small>{{$section->views_cnt}}</small>
                </div>

                @if(count($section->children) > 0)
                    <div class="grid-item-dropdown clearfix" data-dropdown="sections_list-item-{{$section->id}}">
                        <div class="col-xs-12">
                            @foreach($section->children as $child)
                                <p>
                                    <a href="{{route_to_section($child)}}" class="grid-item-dropdown-link" style="white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;">
                                        <span class="rating rating-sm rating-white rating-square rating-inline">
                                            {{$child->rating}}
                                        </span>

                                        {{$child->title}}
                                    </a>
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>