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
                @if(isset($activity->params['deleted']) && $activity->params['deleted'] == true)
                    Вы удалили данные профиля:
                @endif
            </p>

            <p class="comment-body-topic">
                <strong>
                    {{$activity->params['data']['field_user_group']['field_group']['name']}}
                </strong>
            </p>
        </div>
        <div class="comment-body-preview">
            @foreach($activity->params['data']['field_user_value'] as $value)
                {{$value['field']['name']}}: {{$value['value']}}
                <br>
            @endforeach
        </div>
    </div>

</div>