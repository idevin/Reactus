@set('user', $activity->user)

<div class="comment-item comment-top">
    <div class="comment-header clearfix">
        <div class="comment-header-right">
            <div class="comment-date">
                <p><span class="icon icon-date-gray"></span> {{getFormatedDate($activity->created_at)}} </p>
            </div>
        </div>

        <div class="comment-user">
            <div class="navbar-user navbar-user-white">
                <div class="navbar-user-av">
                    <div class="navbar-user-av-block">
                        @if ($user->avatar)
                            <img src="{{$user->imageUrl('70x70', 'avatar') }}" width="70" height="70" alt=""/>
                        @else
                            {{--<img src="http://placehold.it/70x70" width="70" height="70" alt=""/>--}}
                        @endif
                    </div>
                </div>
                <div class="navbar-user-info">
                    <p class="navbar-user-name">{{username($user)}}</p>

                    <p class="navbar-user-role">Писатель 29 lvl</p>
                </div>
            </div>
        </div>
    </div>

    <div class="comment-body">
        @if($activity->object())
            <div class="comment-body-activity">
                <p>
                    Вы написали статью:
                </p>

                <p class="comment-body-topic">
                    <strong>
                        <a href="{{route_to_article($activity->object())}}"
                           target="_blank">{!! html_entity_decode($activity->object()->title) !!}</a>
                    </strong>
                </p>
            </div>
        @endif
    </div>
</div>