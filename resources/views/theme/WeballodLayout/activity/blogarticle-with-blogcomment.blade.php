@if($activity->object() && $activity->fromObject())
    <div class="comment-item comment-top">
        <div class="comment-header clearfix">
            <div class="comment-header-right">
                <div class="comment-date">
                    <p><span class="icon icon-date-gray"></span> {{getFormatedDate($activity->created_at)}} </p>
                </div>
            </div>


            @set('fromUser', $activity->fromUser()->get()->first())
            @set('user', $activity->user()->get()->first())

            <div class="comment-user">
                <div class="navbar-user navbar-user-white">
                    <div class="navbar-user-av">
                        <div class="navbar-user-av-block">
                            @if ($fromUser->avatar)
                                <img src="{{$fromUser->imageUrl('70x70', 'avatar') }}" width="70" height="70" alt=""/>
                            @else
                                {{--<img src="http://placehold.it/70x70" width="70" height="70" alt=""/>--}}
                            @endif
                        </div>
                    </div>
                    <div class="navbar-user-info">
                        <p class="navbar-user-name">{{username($fromUser)}}</p>

                        <p class="navbar-user-role">Писатель 29 lvl</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="comment-body">
            <div class="comment-body-activity">
                <p>
                    @if($fromUser->id != $user->id)
                        {{username($fromUser)}} оставил
                    @else
                        Вы оставили
                    @endif

                    комментарий к статье в Вашем Блоге
                    <a
                            href="{{route(\App\Models\BlogArticle::class . '.show_origin', ['title' => $activity->object()->slug, 'id' => $activity->object()->id])}}#c{{$activity->fromObject()->id}}"
                            target="_blank">{!! html_entity_decode($activity->object()->title) !!}</a>:
                </p>
            </div>

            <div class="comment-body-preview">
                {!! html_entity_decode($activity->fromObject()->content) !!}
            </div>
        </div>
    </div>
@endif