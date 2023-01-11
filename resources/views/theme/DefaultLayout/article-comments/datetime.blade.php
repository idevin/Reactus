<div class="comment-date">
    <p><span class="icon icon-date-gray"></span>
        @if($comment->updated_at)
           Обновлено {{ datetime_format($comment->updated_at) }} ({{$comment->updated_at->diffForHumans()}})
        @else
            {{ datetime_format($comment->created_at) }} ({{$comment->created_at->diffForHumans()}})
        @endif

    </p>
</div>