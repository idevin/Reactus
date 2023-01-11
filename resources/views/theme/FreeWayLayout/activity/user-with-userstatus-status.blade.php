@if(!empty($activity->params['status']))
    <div class="comment-item comment-top">
        <div class="comment-header clearfix">
            <div class="comment-header-right">
                <div class="comment-date">
                    <p><span class="icon icon-date-gray"></span> {{getFormatedDate($activity->created_at)}} </p>
                </div>
            </div>
        </div>

        <div class="comment-body">
            <div class="comment-body-activity">
                <p>
                    Вы обновили статус:
                </p>
            </div>

            <div class="comment-body-preview">
                {{$activity->params['status']}}
            </div>
        </div>
    </div>
@endif