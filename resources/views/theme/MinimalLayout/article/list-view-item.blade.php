<div class="list-item">
    <div class="list-item-wrapper clearfix" @if(!$article->isStatusPublished()) style="opacity: 0.2;" @endif>

        <a style="cursor:pointer; display: block;" href="{{ route_to_article($article) }}" class="list-item-title">
            <div class="list-item-params">
                <span class="list-item-rating rating rating-gray">{{ rating_format($article->rating) }}</span>

                <p class="list-item-param hidden-xs text-muted">
                    <span class="icon icon-views"></span> {{ counter_format($article->views_cnt) }}
                </p>

                <p class="list-item-param">
                    <span class="icon icon-comments"></span>
                    {{ counter_format($article->comments_cnt) }}

                    @if ($article->last_comment_author)
                        / &nbsp;{{ $article->last_comment_author }}
                        <br/>
                        <span style="margin-left: 22px;">{{ getFormatedDate($article->last_comment_at) }}</span>
                    @endif
                </p>
            </div>

            <div class="list-item-image">
                <div class="list-item-image-wrapper">
                    @if(count($article->images) > 0)
                        <img src="{{ $article->images->first()->thumbs['thumb280x157'] }}" width="200" height="110"
                             alt=""/>
                        @else
                        <img src="{{ $article->imageUrl('280x157', 'article_slider') }}" width="200" height="110"
                             alt=""/>
                    @endif

                    <span class="list-item-rating rating rating-white">{{ rating_format($article->rating) }}</span>
                    <span class="list-item-category">@if($article->section){{ $article->section->title }}@endif</span>
                </div>
            </div>

            <div class="list-item-desc">
                <strong>{{ $article->title }}</strong>

                <div class="list-item-info">
                    <p><span class="icon icon-date"></span> {{ datetime_format($article->published_at) }}</p>

                    @if(($article->section && $article->section->sectionSetting && (int)$article->section->sectionSetting->show_article_author == 1) || ($article->section && !$article->section->sectionSetting))
                        <p>
                            <span class="icon icon-author"></span>@if($article->author){{ username($article->author) }}@endif
                        </p>
                    @endif

                    @if(!empty($article->getTagsText()))
                        <p>
                            <span class="icon icon-tags"></span> {{ $article->getTagsText() }}
                        </p>
                    @endif
                </div>
            </div>
        </a>
    </div>
</div>