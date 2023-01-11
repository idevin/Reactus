@if($activity->object())
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
                    Вы
                    @if($activity->object()->multi_field == 0)
                        обновили
                    @else
                        добавили данные в
                    @endif
                    профиль:
                </p>

                <p class="comment-body-topic">
                    <strong>
                        {{$activity->object()->name}}
                    </strong>
                </p>
            </div>
            <div class="comment-body-preview">
                @foreach($activity->params['data'] as $data)
                    {{$data['name']}}: {{$data['value']}}
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@endif
