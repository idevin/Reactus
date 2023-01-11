<div class="topic-list-item popular">
    <div class="topic-title">
        <strong>ЧИТАЕМОЕ</strong>
    </div>
    <div class="topic-body">
        <div class="scrollable">

            @foreach($popularArticles as $article)
                <div class="topic-item">
                    <a href="{{ route_to_article($article) }}" class="topic-item-title">
                        <strong>{{ $article->title }}</strong>
                    </a>

                    <p>
                        <small>{{ datetime_format($article->published_at) }}</small>
                    </p>
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
            @endforeach

            <div class="topic-item-more">
                <a href="#" class="btn btn-primary btn-block" data-more>Показать еще</a>
            </div>

        </div>
    </div>
</div>