<div class="comment-item comment-left">
    <div class="comment-header align-top clearfix">

        <div class="comment-header-right">

            @if($user && ($comment->author_id != $object->author_id && $comment->author_id != $user->id))
                @include(theme('article-comments.rating-panel'))
                @include(theme('article-comments.datetime'))
            @endif
        </div>
    </div>

    <div class="pull-left">
        <div class="comment-user">
            <div class="navbar-user navbar-user-white align-top">

                @include(theme('article-comments.user-ava'), ['user' => $comment->author])

                <div class="navbar-user-info">
                    <p class="navbar-user-name">
                        {{ username($comment->author) }}
                    </p>

                    <p class="navbar-user-role">Писатель 29 lvl</p>

                    <div class="navbar-user-actions">
                        @if($user && ($comment->author_id != $object->author_id && $comment->author_id != $user->id))
                            @include(theme('article-comments.user-actions'))
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="comment-body-left">

        @include(theme('article-comments.body'))

        @if($comment->status == \App\Models\Comment::STATUS_APPROVED)
            @include(theme('article-comments.actions'))
        @endif
    </div>
</div>
