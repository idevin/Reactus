<div class="comment-header clearfix" data-id="{{$comment->id}}">
    <div class="comment-header-right">
        @include(theme('article-comments.rating-panel'))
        @include(theme('article-comments.datetime'))
    </div>

    <div class="comment-user">
        <div class="navbar-user navbar-user-white">
            @include(theme('article-comments.user-ava'), ['user' => $comment->author])
            <div class="navbar-user-info">
                <p class="navbar-user-name">{{ username($comment->author) }}</p>

                <p class="navbar-user-role">Писатель 29 lvl</p>
            </div>
        </div>
    </div>

    <div class="comment-user-actions">
        <div class="navbar-user-actions">
            @include(theme('article-comments.user-actions'))
        </div>
    </div>

    <!--
        <div class="comment-user-rewards">
            <div class="author-rewards">
                <span class="icon icon-reward"></span>
                <span class="icon icon-reward"></span>
                <span class="icon icon-reward"></span>
                <span class="icon icon-reward"></span>
                <span class="icon icon-reward"></span>
            </div>
        </div>
        -->
</div>
