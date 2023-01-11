<div class="list-item">
    <div class="list-item-wrapper clearfix">

        <div class="list-item-params">
            <span class="list-item-rating rating rating-gray">{{ rating_format($article->rating) }}</span>

            <p class="list-item-param">
                <span class="icon icon-comments"></span>
                {{ counter_format($article->comments_cnt) }}
                @if ($article->last_comment_author)
                    / &nbsp;{{ $article->last_comment_author }}
                    <br/>
                    {{ datetime_format($article->last_comment_at) }}
                @endif
            </p>

            <p class="list-item-param hidden-xs text-muted">
                <span class="icon icon-views"></span> {{ counter_format($article->views_cnt) }}
            </p>

            <p class="list-item-param hidden-xs text-muted">
                <span class="icon icon-tags"></span> {{ $article->getTagsText() }}
            </p>
        </div>

        <div class="list-item-image">
            <div class="list-item-image-wrapper">
                <picture>
                    @if ($article->image)
                        <img src="{{ $article->imageUrl('200x110', 'article') }}" width="200" height="110" alt=""/>
                    @else
                        {{--<img src="http://placehold.it/200x110" width="200" height="110" alt=""/>--}}
                    @endif
                </picture>

                <span class="list-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
            </div>
        </div>

        <div class="list-item-desc">
            <a href="{{ route_to_article($article) }}" class="list-item-title"><strong>{{ $article->title }}</strong></a>

            <div class="list-item-info">
                <p><span class="icon icon-date"></span> {{ datetime_format($article->published_at) }}</p>

                <p><span class="icon icon-author"></span> @if($article->author){{ $article->author->username }}@endif</p>
            </div>
        </div>
    </div>
</div>