<div class="col-sm-6 col-lg-4">
    <div class="grid-item">
        <a href="{{ route_to_article($article) }}" class="grid-item-image">
            <picture>
                @if ($article->image)
                    <img src="{{ $article->imageUrl('300x170', 'article') }}"/>
                @endif
            </picture>

      <span class="grid-item-category">
        @if ($article->section)
              {{ $article->section->title }}
          @endif
      </span>
            <span class="grid-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
        </a>

        <div class="grid-item-desc">
            <div class="navbar-user navbar-user-white">
                <div class="navbar-user-av">
                    <div class="navbar-user-av-block">
                        @if($article->author)
                            <img src="{{ $article->author->imageUrl('70x70', 'avatar') }}" width="70" height="70" alt=""/>
                        @endif
                    </div>
                </div>
                <div class="navbar-user-info">
                    {{-- <p class="navbar-user-name">{{ $article->author->username }}</p> --}}

                    <p class="navbar-user-role">Писатель 20 lvl</p>
                </div>
            </div>
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
