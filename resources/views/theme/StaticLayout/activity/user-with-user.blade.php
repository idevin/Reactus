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
                @if(!isset($activity->params['avatar']))
                    Вы обновили основные данные профиля:
                @else
                    Вы обновили аватар:
                @endif
            </p>
        </div>

        <div class="comment-body-preview">
            @if(!isset($activity->params['avatar']))
                {{$activity->object()->first_name}} <br>
                {{$activity->object()->last_name}} <br>
                {{$activity->object()->middle_name}} <br>
            @else
                @if(isset($activity->params['folder']) && isset($activity->params['image']) && file_exists(public_path('/uploads/storage/avatar/thumbs/240x240/') . $activity->params['image']))
                    <img src="/uploads/storage/avatar/thumbs/240x240/{{$activity->params['image']}}" alt=""/>
                @endif
            @endif
        </div>

    </div>

</div>