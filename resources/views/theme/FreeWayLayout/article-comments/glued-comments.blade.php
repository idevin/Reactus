<div class="comment-item comment-top">

    @foreach($comments as $index => $comment)

        @if($index == 0)
            @include(theme('article-comments.profile'), ['comment' => $comment])
        @endif

        <div class="comment-block" data-id="{{$comment->id}}">
            @include(theme('article-comments.body'), ['comment' => $comment])
            @include(theme('article-comments.actions'), ['comment' => $comment, 'glue' => true])

            @include(theme('article-comments.complaints'), ['comment' => $comment])

        </div>
        <div class="comment-block-reply" data-id="{{$comment->id}}"></div>

        @if($index+1 != count($comments) && object_minute_difference($comments[$index+1], $comment) >= config('netgamer.comments.glued'))
            @include(theme('article-comments.profile'), ['comment' => $comments[$index+1]])
        @endif

    @endforeach
</div>