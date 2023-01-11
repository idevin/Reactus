<div class="col-sm-6 col-lg-4">
    <div class="grid-item" @if(!$article->isStatusPublished()) style="opacity: 0.2;" @endif>
        <a href="{{ route_to_article($article) }}" class="grid-item-image">
            <picture>
                @if(count($article->images) > 0)
                    <img src="{{ $article->images->first()->thumbs['thumb280x157'] }}" width="200" height="110"
                         alt=""/>
                @else
                    <img src="{{ $article->imageUrl('280x157', 'article_slider') }}" width="200" height="110"
                         alt=""/>
                @endif
            </picture>

            <span class="grid-item-category">@if($article->section){{ $article->section->title }}@endif</span>
            <span class="grid-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
        </a>

        <div class="grid-item-desc">

            @if(($article->section && $article->section->sectionSetting && (int)$article->section->sectionSetting->show_article_author == 1) || ($article->section && !$article->section->sectionSetting))
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
            @endif

            <p class="grid-item-date">
                <small>{{ datetime_format($article->published_at) }}</small>
            </p>
            <a href="{{ route_to_article($article) }}" class="h4"><strong>{{ $article->title }}</strong></a>

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
        </div>
    </div>
</div>