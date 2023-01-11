<div class="topic-list-item sections">
    <div class="topic-title">
        <strong>РАЗДЕЛЫ</strong>
    </div>
    <div class="topic-body">

        @foreach ($sections as $item)

            @if (!$item->is_community)
                <div class="topic-item">
                    <div class="topic-item-wrapper">
                        <a href="#" class="list-item-dropdown-toggle" data-dropdown-toggle="sections_right_list-item-{{ $item->id }}"></a>

                        <div class="topic-item-image">
                            <picture>
                            </picture>
                        </div>

                        <div class="topic-item-left">
                            <a href="route_to_section($item) " class="topic-item-title h5"><strong>{{ $item->title }}</strong></a>

                            <div class="item-params">
                                <div class="item-param">
                                    <span class="icon icon-comments-light"></span>
                                    <small>{{ counter_format($item->articles_cnt) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($item->getImmediateDescendants())
                        <div class="list-item-dropdown" data-dropdown="sections_right_list-item-{{ $item->id }}">
                            @foreach ($item->getImmediateDescendants() as $subitem)
                                @if (!$subitem->is_community)
                                    <p><a href="{{ route_to_section($subitem) }}"><strong>{{ $subitem->title }}</strong></a></p>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>
            @endif
        @endforeach

    </div>
</div>
