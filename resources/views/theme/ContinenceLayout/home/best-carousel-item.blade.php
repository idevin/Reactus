<div class="carousel-item" data-range="{{ $interval }}">
    <div class="grid-item">
        <a href="{{ route_to_article($article) }}" class="grid-item-image">
            @if ($article->image)
                <img src="{{ $article->imageUrl('280x157', 'article') }}" width="280" height="157" alt=""/>
            @endif
            <span class="grid-item-category">@if($article->section){{ $article->section->title }}@endif</span>
            <span class="grid-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
        </a>

        <div class="grid-item-desc">
            <div class="navbar-user navbar-user-white">
                <div class="navbar-user-av">
                    <div class="navbar-user-av-block">
                        <img src="{{ $article->author->imageUrl('70x70', 'avatar') }}" width="70" height="70" alt=""/>
                    </div>
                </div>
                <div class="navbar-user-info">
                    <p class="navbar-user-name">@if($article->author){{ $article->author->username }}@endif</p>

                    <p class="navbar-user-role">Писатель {{$article->author->rating}} lvl</p>
                </div>
            </div>
            <p class="grid-item-date">
                <small>{{ datetime_format($article->published_at) }}</small>
            </p>
            <a href="{{ route_to_article($article) }}" class="grid-item-link"><strong>{{ $article->title }}</strong></a>

            <div class="item-params">
                <div class="item-param">
                    <span class="icon icon-views"></span>
                    <small>{{ counter_format($article->views_cnt) }}</small>
                </div>
                <div class="item-param">
                    <span class="icon icon-like"></span>
                    <small>{{ counter_format($article->likes_cnt) }}</small>
                </div>
                <div class="item-param">
                    <span class="icon icon-comments"></span>
                    <small>{{ counter_format($article->comments_cnt) }}</small>
                </div>
            </div>
            <div class="grid-item-text">
                <p>{!! truncate_content($article->content, 150, true, true) !!}</p>
            </div>
        </div>
    </div>
</div>
