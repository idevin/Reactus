<div class="comment-rating pull-right">
    <div class="rating-panel comment" data-id="{{$comment->id}}">
        <div class="rating-panel-current  js-open-rating">
            <p class="rating-panel-current-value">{{ rating_format($comment->rating) }}</p>
        </div>

        <div class="rating-panel-control js-rating comment" data-id="{{$comment->id}}">
            <div class="rating-panel-values js-circle-rating comment" data-start-angle="60">
                <div class="rating-panel-value">-1</div>
                <div class="rating-panel-value js-close-rating"><span class="icon icon-close"></span></div>
                <div class="rating-panel-value">+1</div>
                <div class="rating-panel-value">+2</div>
            </div>

            <div class="rating-panel-back  js-close-rating"></div>
        </div>
    </div>
</div>