<li class="carousel-item">
    <div class="list-item clearfix">
        <div class="list-item-params clearfix">
            <span class="list-item-rating rating rating-gray">{{ rating_format($article->rating) }}</span>

            <p class="list-item-param hidden-xs text-muted">
                <span class="icon icon-views"></span> {{ counter_format($article->views_cnt) }}
            </p>

            <p class="list-item-param">
                <span class="icon icon-comments"></span>
                {{ counter_format($article->comments_cnt) }}
                @if ($article->last_comment_at)
                    / &nbsp;{{ $article->last_comment_author }}
                    <br/>
                    {{ $article->last_comment_at->format('d.m.Y в G:i') }}
                @endif
            </p>
        </div>

        <div class="list-item-image">
            <div class="list-item-image-wrapper">
                @if ($article->image)
                    <img src="{{ $article->imageUrl('200x110', 'article') }}" alt=""/>
                @endif
                <span class="list-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
            </div>
        </div>

        <div class="list-item-desc">
            <a href="{{ route_to_article($article) }}" class="list-item-title"><strong>{{ $article->title }}</strong></a>

            <div class="list-item-info">
                <p><span class="icon icon-date"></span> {{ datetime_format($article->published_at) }}</p>

                <p><span class="icon icon-author"></span>@if($article->author){{ $article->author->username }}@endif</p>

                <p>
                    @if (count($article->tags) > 0)
                        <span class="icon icon-tags"></span>

                        @foreach ($article->tags as $tag)
                           {{ $tag->name }}
                        @endforeach
                    @endif
                </p>
            </div>
        </div>
    </div>
</li>
