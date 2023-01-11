<div class="list-items hidden" data-view="list">
    @foreach($communities as $community)
        <div class="list-item">
            <div class="list-item-wrapper clearfix">

                @if(isset($c_sections[$community->id]))
                    <a href="{{route_to_section($community)}}" class="list-item-dropdown-toggle"
                       data-dropdown-toggle="communities_list-item-{{$community->id}}"></a>
                @endif

                <div class="list-item-params">
                    <span class="list-item-rating rating rating-gray">{{$community->rating}}</span>

                    @if($community->lastComment)
                        <p class="list-item-param">
                            <span class="icon icon-comments"></span>

                            {{(int)$community->comments_cnt}} / &nbsp; {{username($community->lastComment->author)}}
                            <br/>
                            {{getFormatedDate($community->lastComment->created_at)}}
                        </p>
                    @endif

                    <p class="list-item-param hidden-xs text-muted">
                        <span class="icon icon-views"></span> {{$community->views_cnt}}
                    </p>

                    @if(count($community->tags) > 0)
                        <p class="list-item-param hidden-xs text-muted">
                            <span class="icon icon-tags"></span> {{$community->getTagsText()}}
                        </p>
                    @endif
                </div>

                <div class="list-item-image">
                    <div class="list-item-image-wrapper">
                        <picture>
                            <source media="(min-width: 1240px)" srcset="{{$community->imageUrl('200x110', 'community')}}">
                            <img src="{{$community->imageUrl('200x180', 'community')}}" alt=""/>
                        </picture>

                        <span class="list-item-rating rating rating-white">{{$community->rating}}</span>
                    </div>
                </div>

                <div class="list-item-desc">
                    <a href="{{route_to_section($community)}}" class="list-item-title"><strong>{!! $community->title !!}</strong></a>

                    <div class="list-item-info">
                        <p><span class="icon icon-date"></span>
                            {{getFormatedDate($community->created_at)}}
                        </p>
                        @if($community->section_user)
                            <p><span class="icon icon-author"></span> {{username($community->section_user->user)}}</p>
                        @endif
                    </div>
                </div>
            </div>
            @if(isset($c_sections[$community->id]))
                <div class="list-item-dropdown clearfix" data-dropdown="communities_list-item-{{$community->id}}">
                    <div class="col-xs-12">

                        @foreach($c_sections[$community->id] as $index => $cSection)
                            <div class="col-md-4">
                                <a href="{{route_to_section($cSection)}}">
                                    <span class="icon icon-comments-light"></span>
                                    {!! $cSection['title'] !!}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>