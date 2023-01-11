<div class="grid-items" data-view="grid">
    <div class="row">

        @foreach($communities as $community)
            <div class="col-sm-6 col-lg-4">
                <div class="grid-item">
                    <a href="{{route_to_section($community)}}" class="grid-item-image">

                        <picture>
                            @if(!empty($community->image))
                                <source media="(min-width: 1240px)" srcset="{{$community->imageUrl('300x170', 'community')}}">
                                <source media="(min-width: 768px)" srcset="{{$community->imageUrl('480x250', 'community')}}">
                                <source media="(max-width: 480px)" srcset="{{$community->imageUrl('480x250', 'community')}}">
                                <img src="{{$community->imageUrl('768x300', 'community')}}">
                            @endif
                        </picture>


                        <span class="grid-item-rating rating rating-white rating-square">{{$community->rating}}</span>
                    </a>

                    <div class="grid-item-desc">

                        @if(!empty($community->section_user))
                            <div class="navbar-user navbar-user-white">
                                <div class="navbar-user-av">
                                    @if($community->section_user->image)
                                        <div class="navbar-user-av-block">
                                            <img src="{{$community->section_user->imageUrl('70x70', 'community')}}" width="70" height="70" alt="">
                                        </div>
                                    @endif
                                </div>
                                <div class="navbar-user-info">
                                    <p class="navbar-user-name">{{username($community->section_user)}}</p>

                                    <p class="navbar-user-role">Писатель {{$community->section_user->rating}} lvl</p>
                                </div>
                            </div>
                        @endif


                        <p class="grid-item-date">
                            <small>{{getFormatedDate($community->created_at)}}</small>
                        </p>

                        <a href="{{route_to_section($community)}}" class="grid-item-title">
                            <strong>{!! $community->title !!}</strong>
                        </a>

                        <div class="item-params">
                            @if(isset($c_sections[$community->id]))
                                <a href="{{route_to_section($community)}}" class="grid-item-dropdown-toggle"
                                   data-dropdown-toggle="sections_grid-item-{{$community->id}}"></a>
                            @endif

                            @if(count($community->tags) > 0)
                                <div class="item-param item-param-block text-muted">
                                    <span class="icon icon-tags"></span>
                                    <small>{{$community->getTagsText()}}</small>
                                </div>
                            @endif

                            <div class="item-param">
                                <span class="icon icon-communities"></span>
                                <small>{{$community->articles_cnt}}</small>
                            </div>
                            <div class="item-param">
                                <span class="icon icon-views"></span>
                                <small>{{$community->views_cnt}}</small>
                            </div>

                            @if(isset($c_sections[$community->id]))
                                <div class="grid-item-dropdown clearfix" data-dropdown="communities_grid-item-{{$community->id}}">
                                    @foreach($c_sections[$community->id] as $index => $cSection)
                                        <p>
                                            <a href="{{route_to_section($cSection)}}" class="grid-item-dropdown-link">
                                                <span class="rating rating-sm rating-white rating-square rating-inline">{{$cSection['rating']}}</span>

                                                {!! $cSection['title'] !!}
                                            </a>
                                        </p>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>