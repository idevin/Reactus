<div class="topic-item carousel-item">
    <a href="{{ redirectTo($article->url) }}" class="topic-item-title"><strong>{{ $article->title }}</strong></a>

    <p>
        <small>{{ datetime_format($article->published_at) }}</small>
    </p>
    <div class="item-params">
        <div class="item-param">
            <span class="icon icon-views"></span>
            <small>{{ counter_format($article->views_cnt) }}</small>
        </div>
        <div class="item-param">
            <span class="icon icon-comments"></span>
            <small>{{ counter_format($article->comments_cnt) }}</small>
        </div>
    </div>
</div>