<div class="list-item" @if((int)$section->is_secret == 1) style="opacity: 0.2;" @endif>
    <div class="list-item-wrapper clearfix">

        <div class="list-item-params">

            @if(($section->sectionSetting && (int)$section->sectionSetting->show_rating == 1) || !$section->sectionSetting)
                <span class="list-item-rating rating rating-gray">{{$section->rating}}</span>
            @endif

            @set('lastArticle', $section->lastArticle())

            @if($lastArticle)
                <p class="list-item-param">
                    <span class="icon icon-article"></span>
                    <a href="{{route_to_article($lastArticle)}}">{{$lastArticle->title}}</a>
                    <br>
                    Автор: {{username($lastArticle->author)}}
                </p>
            @endif

            @if($section->lastComment)
                <p class="list-item-param">
                    <span class="icon icon-comments"></span>
                    {{(int)$section->comments_cnt}}
                </p>
            @endif

            <p class="list-item-param hidden-xs text-muted">
                <span class="icon icon-communities"></span> {{$section->articles_cnt}}
            </p>
        </div>

        <div class="list-item-image">
            <div class="list-item-image-wrapper">

                <a href="@if((int)$section->is_secret == 1){{route_to_hidden_section($section)}}@else{{route_to_section($section)}}@endif">
                    <picture>
                        <source media="(min-width: 1240px)" srcset="{{$section->imageUrl('200x110', 'section')}}">
                        <img src="{{$section->imageUrl('200x110', 'section')}}" alt="">
                    </picture>

                    @if(($section->sectionSetting && (int)$section->sectionSetting->show_rating == 1) || !$section->sectionSetting)
                        <span class="list-item-rating rating rating-white">{{$section->rating}}</span>
                    @endif

                    @if($section->parent && $section->parent->parent_id != null)
                        <span class="list-item-category">{{$section->parent->title}}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="list-item-desc">
            <strong>
                <a class="list-item-title"
                   href="@if((int)$section->is_secret == 1){{route_to_hidden_section($section)}}@else{{route_to_section($section)}}@endif">

                    {!! $section->title !!}
                </a>
            </strong>

            <div class="list-item-info">
                <p><span class="icon icon-date"></span>
                    {{getFormatedDate($section->created_at)}}
                </p>
                @if($section->section_user)
                    <p><span class="icon icon-author"></span> {{username($section->section_user->user)}}</p>
                @endif

                @if(count($section->tags) > 0)
                    <p>
                        <span class="icon icon-tags"></span> {{implode(',', $section->tags->pluck('name')->toArray())}}
                    </p>
                @endif
            </div>

        </div>

        @if(count($section->children) > 0)
            <a href="#" class="list-item-dropdown-toggle" data-dropdown-toggle="sections_list-item-{{$section->id}}"></a>
        @endif
    </div>

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
                            <a href="{{route_to_section($child)}}">
                                <span class="icon icon-comments-light"></span>
                                {{$child->title}}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>