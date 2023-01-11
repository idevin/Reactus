<div class="comment-footer clearfix">
    <div class="comment-reply pull-right">
        <a href="#" data-id="{{$comment->id}}" data-username="{{username($comment->author)}}" class="comment-add"><span
                    class="icon icon-reply"></span>Ответить</a>
        <a href="#" data-id="{{$comment->id}}" data-username="{{username($comment->author)}}" data-user_id="{{$comment->author->id}}"
           class="comment-quote"><span
                    class="icon icon-quote"></span>Цитировать</a>

        @if(\Auth::user() && ($comment->author_id == \Auth::user()->id || \Auth::user()->superadmin == 1))
            @if(minute_difference(date('Y-m-d H:i:s', time()), $comment->created_at) <=config('netgamer.comments.editable'))
                <a href="#" @if(isset($glue)) data-glue="1" @else data-glue="0" @endif
                data-id="{{$comment->id}}"
                   data-username="{{username($comment->author)}}"
                   class="comment-edit"><span class="icon icon-quote"></span>Редактировать</a>
            @endif
            <a href="#" data-toggle="modal" data-target="#delete-comment" data-id="{{$comment->id}}" class="comment-delete"><span
                        class="icon icon-quote"></span>Удалить</a>
        @endif
    </div>

    <div class="comment-actions pull-left">
        @if(\Auth::user() && $comment->author_id != \Auth::user()->id)
            <button type="button" class="btn btn-icon-circle" data-comment="{{$comment}}">
                <span class="icon icon-complaint-small"></span>

                <span class=""></span>
            </button>
        @endif

        <button type="button" class="btn btn-icon-circle">
            <span class="icon icon-share"></span>
        </button>

        <button type="button" class="btn btn-icon-circle">
            <span class="icon icon-settings"></span>
        </button>
    </div>
</div>