@if(count($discussedArticles) > 0)
    <div class="topic-list-item discussed">
        <div class="topic-title">
            <a href="#" class="topic-list-toggle pull-right" data-toggle-period=".js-more-discussed" data-period="0" data-period-init="false">ЗА
                МЕСЯЦ</a>
            <strong>КОММЕНТИРУЕМОЕ</strong>
        </div>
        <div class="topic-body">
            <div class="scrollable">
                @foreach($discussedArticles as $article)
                    <div class="topic-item">
                        <a href="{{ route_to_article($article) }}" class="topic-item-title">
                            <!-- <picture>
                               <source media="(min-width: 768px)" srcset="http://placehold.it/300x200">
                               <img src="http://placehold.it/768x200" alt="">
                             </picture> -->
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
            </div>
        </div>
    </div>
@endif
