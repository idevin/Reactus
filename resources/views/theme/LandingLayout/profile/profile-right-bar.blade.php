<div class="col-md-4 col-lg-3">
    <div class="sidebar sidebar-inner">
        <div class="sidebar-block">

            <div class="user-profile">
                <div class="user-profile-online">Online</div>

                <div class="user-profile-avatar">

                    @if(!empty($user->thumbs))
                        <img src="{{$user->thumbs['thumbs']['thumb150x150']}}" class="img-responsive"/>
                    @endif

                    @if(\Auth::user() && $user->id == \Auth::user()->id)
                        <form class="upload-avatar">
                            <div class="user-profile-avatar-upload">
                                <div class="btn-upload btn-stretch">
                                    <input type="file" name="avatar" id="av-upload">

                                    <label for="av-upload" class="btn btn-primary btn-stretch">
                                        <span class="icon icon-pencil"></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>

                <p class="user-profile-name">
                    <strong>
                        {{username($user)}}
                    </strong>
                </p>

                <div class="user-profile-lvl">

                    @if(\Auth::user() && $user->id == \Auth::user()->id)
                        <span class="user-profile-lvl-icon">
                         <a href="{{route('profile.edit')}}"><span class="icon icon-pencil-small"></span></a>
                        </span>
                    @endif

                    @foreach($user->roles as $role)
                        {{$role->description}}
                    @endforeach
                </div>

                <div class="user-profile-rating clearfix">
                    <span class="pull-right">Рейтинг: {{(int)$user->rating}}</span>

                    @if($user->created_at)
                        <span class="pull-left">
                       {{time_ago($user->created_at)}} на сайте
                    </span>
                    @endif
                </div>

                <style>
                    .user-profile-status p {
                        min-height: 15px;
                    }
                </style>

                <div class="user-profile-status">
                    <p data-empty="@if(empty($user->status)){{1}}@else{{0}}@endif">
                        @if(\Auth::user() && $user->id == \Auth::user()->id)
                            @if(!empty($user->status))
                                {{$user->status->status}}
                            @else
                                <quote>Кликните, чтобы обновить статус...</quote>
                            @endif
                        @else
                            {{$user->status}}
                        @endif
                    </p>
                </div>

                @if(\Auth::user() && $user->id == \Auth::user()->id)
                    <script>
                        $(document).on('click', '.user-profile-status p', function () {

                            if ($(this).data('empty') == 1) {
                                $(this).text('');
                            }

                            $(this).attr('contenteditable', true);
                            $(this).focus();

                            return false;
                        });

                        var element = $('.user-profile-status p');

                        var saveStatus = function (status) {
                            $.ajax({
                                url: '/api/profile/save_status',
                                method: 'POST',
                                data: {
                                    status: status,
                                    token: window.user.auth_token,
                                    user_status_emotion_id: 2
                                },
                                success: function (data) {

                                    if (data.data.user.status.length == 0) {
                                        element.text('Кликните, чтобы обновить статус...');
                                        element.data('empty', 1);
                                    } else {
                                        element.data('empty', 0);
                                    }
                                }
                            });
                        };

                        $(document).on('keypress', '.user-profile-status p', function (e) {
                            if (e.which == 13) {
                                e.preventDefault();
                                $(this).removeAttr('contenteditable');
                                saveStatus($(this).text());

                                return false;
                            } else {
                                return true;
                            }
                        });

                        $(document).on('click', function (e) {
                            if ($('.user-profile-status p')[0].hasAttribute('contenteditable')) {
                                saveStatus($('.user-profile-status p').text());
                            }
                        });
                    </script>
                @endif

                @if(\Auth::user() && $user->id == \Auth::user()->id)
                    {{--<div class="user-profile-money">--}}
                <!--
                        <div class="user-profile-money-item">
                            <span class="user-profile-money-circle gold"></span> 250 000
                        </div>

                        <div class="user-profile-money-item">
                            <span class="user-profile-money-circle silver"></span> 250 000
                        </div>

                        <div class="user-profile-money-item">
                            <span class="user-profile-money-circle bronze"></span> 250 000
                        </div>
                        -->
                    {{--</div>--}}
                @endif

                @if(\Auth::user() && $user->id != \Auth::user()->id)
                <!--
                    <ul class="user-profile-actions list-unstyled">
                        <li class="user-profile-actions-item">
                            <a href="#" class="btn btn-icon btn-lg btn-block">
                                <span class="icon icon-btn-chat"></span> Отправить сообщение
                            </a>
                        </li>

                        <li class="user-profile-actions-item">
                            <a href="#" class="btn btn-icon btn-lg btn-block">
                                <span class="icon icon-btn-plus"></span> Добавить в контакты
                            </a>
                        </li>

                        <li class="user-profile-actions-item">
                            <a href="#" class="btn btn-icon btn-lg btn-block">
                                <span class="icon icon-btn-gift"></span> Отправить подарок
                            </a>
                        </li>

                        <li class="user-profile-actions-item">
                            <a href="#" class="btn btn-icon btn-lg btn-block">
                                <span class="icon icon-btn-complaint"></span> Пожаловаться
                            </a>
                        </li>

                        <li class="user-profile-actions-item">
                            <a href="#" class="btn btn-icon btn-lg btn-block">
                                <span class="icon icon-btn-subscribe"></span> Подписаться
                            </a>
                        </li>
                    </ul>
                    -->
                @endif
                @if(\Auth::user() && $user->id == \Auth::user()->id)
                    <ul class="user-profile-links list-unstyled">
                        <li class="user-profile-links-item">
                            <a href="{{route('public.profile.sections', ['user' => $user->username])}}">Мои Разделы</a>
                        </li>

                        <li class="user-profile-links-item">
                            <a href="{{route('public.profile.articles', ['user' => $user->username])}}">Мои Статьи</a>
                        </li>

                        <li class="user-profile-links-item">
                            <a href="{{route('public.profile.security', ['user' => $user->username])}}">Безопасность</a>
                        </li>
                    </ul>
                @else
                    <ul class="user-profile-links list-unstyled">
                        <li class="user-profile-links-item">&nbsp;</li>
                    </ul>
                @endif
            </div>

        </div>
    </div>
</div>
