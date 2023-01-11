<!--suppress JSUnresolvedFunction -->
<div class="comments-section">

    <div class="comments-header clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <p class="comments-title">
                        КОММЕНТАРИИ

                        <a href="#"><span class="icon icon-fire"></span></a>
                    </p>
                </div>

                <div class="col-md-3">
                    <select id="sort-comments" class="no-bg bold">
                        <option value="date">По дате</option>
                        <option value="rating">По рейтингу</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="comments-list">
                    @foreach($comments as $index =>$comment)
                        <a id="c{{$comment->id}}" name="c{{$comment->id}}"></a>

                        @if($comment->status == \App\Models\Comment::STATUS_ON_MODERATION && (Auth::user() && $comment->author_id == Auth::user()->id))
                            <div class="transparent" style="opacity: 0.2;">
                                @endif

                                @if($comment->status == \App\Models\Comment::STATUS_APPROVED ||
                                ($comment->status == \App\Models\Comment::STATUS_ON_MODERATION) &&
                                 \Auth::user() && $comment->author_id == \Auth::user()->id)

                                    <div class="comment-block" data-id="{{$comment->id}}">
                                        @if(comment_is_short($comment->content))
                                             @include(theme('article-comments.short-comment'))
                                        @else
                                            @include(theme('article-comments.full-comment'))
                                        @endif
                                    </div>
                                    <div class="comment-block-reply" data-id="{{$comment->id}}"></div>
                                @endif

                                @if(Auth::user() && ($comment->status == \App\Models\Comment::STATUS_ON_MODERATION && $comment->author_id == Auth::user()->id))
                            </div>
                        @endif

                    @endforeach

                    <div class="comment-wrapper"></div>
                </div>

                <div class="comment-wrapper-send">
                    <div class="comment-send clearfix">

                        <div class="alert alert-danger error hidden" role="alert"></div>

                        <input type="hidden" value="" class="parent-id">

                        <div class="comment-wysiwig"></div>

                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-lg btn-xlg comment-submit"
                                    data-o_id="{{$article->id}}"
                                    data-o="{{\App\Models\Article::class}}">
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>

                <div class="comment-template-send" style="display: none;">
                    <div class="comment-send clearfix">

                        <div class="alert alert-danger error hidden" role="alert"></div>

                        <input type="hidden" value="" class="parent-id">

                        <div class="comment-edit-wysiwig"></div>

                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-lg btn-xlg comment-edit-button"
                                    data-o_id="{{$article->id}}"
                                    data-o="{{\App\Models\Article::class}}">
                                Отправить
                            </button>

                            <button type="submit" class="btn btn-cancel btn-lg btn-xlg comment-cancel-button">
                                Отмена
                            </button>
                        </div>
                    </div>
                </div>

                @if (count($comments) > 0)
                    @include(theme('partials.pagination'), ['paginator' => $comments])
                @endif

            </div>
        </div>
    </div>

</div>
