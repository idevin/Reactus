<div class="comment-item comment-top">
    <div class="comment-header clearfix">
        <div class="comment-header-right">
            @if($user && ($comment->author_id != $object->author_id && ($comment->author_id != $user->id)))
                @include(theme('article-comments.rating-panel'))
                @include(theme('article-comments.datetime'))
            @endif
        </div>

        <div class="comment-user">
            <div class="navbar-user navbar-user-white">

                @include(theme('article-comments.user-ava'), ['user' => $comment->author])
                <div class="navbar-user-info">
                    <p class="navbar-user-name">{{ username($comment->author) }}</p>

                    <p class="navbar-user-role">{{rolesString($comment->author->roles)}} {{$comment->author->rating}} lvl</p>
                </div>
            </div>
        </div>

        <div class="comment-user-actions">
            <div class="navbar-user-actions">
                @if($user && ($comment->author_id != $object->author_id && ($comment->author_id != $user->id)))
                    @include(theme('article-comments.user-actions'))
                @endif
            </div>
        </div>

    </div>

    @include(theme('article-comments.body'))

    @if($comment->status == \App\Models\Comment::STATUS_APPROVED)
        @include(theme('article-comments.actions'))
    @endif

    @include(theme('article-comments.complaints'))

</div>
