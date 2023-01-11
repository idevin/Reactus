@extends(theme('profile'))

@section('profile-content')

    @set('birthday', get_profile_field($profileFields, 'birthday'))
    @set('last_name', get_profile_field($profileFields, 'last_name'))
    @set('first_name', get_profile_field($profileFields, 'first_name'))
    @set('middle_name', get_profile_field($profileFields, 'middle_name'))
    @set('sex', get_profile_field($profileFields, 'sex'))
    @set('hidden', true)

    @foreach(['birthday', 'last_name', 'first_name', 'middle_name', 'sex'] as $variable)
        @if(isset($$variable) && $$variable->value && $$variable->value['visibility'] != 2)
            @set('hidden', false)
        @endif
    @endforeach

    <div class="col-md-8 col-lg-9">
        <h2 class="main-heading">Профиль</h2>

        <div class="content-body">
            <div class="profile-body">

                <div class="profile-section bordered">
                    <div class="clearfix">

                        @if(\Auth::user() && $user->id == \Auth::user()->id)
                            <div class="profile-section-action pull-right">

                                <a href="{{route('public.profile.edit', ['user' => $user->username])}}">Редактировать</a>
                            </div>
                        @endif

                        <h3><strong>О себе</strong></h3>

                        @if($hidden == true)
                            <div style="text-align:center;">Тут ничего не найдено...</div>
                        @endif
                    </div>

                    <div class="clearfix">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-sm-12">

                                            @if($hidden == false)
                                                <h5><strong>Персональные данные</strong></h5>
                                            @endif

                                            @if(isset($birthday) && $birthday->value && $birthday->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        День рождения:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if((int)$user->birthday > 0)
                                                            {{date('d.m.Y', strtotime($user->birthday))}}
                                                            @else
                                                            &mdash;
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isset($last_name) && $last_name->value && $last_name->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        Фамилия:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if($user->last_name)
                                                            {{$user->last_name}}
                                                            @else
                                                            &mdash;
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isset($first_name) && $first_name->value && $first_name->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        Имя:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if($user->first_name)
                                                            {{$user->first_name}}
                                                            @else
                                                            &mdash;
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isset($middle_name) && $middle_name->value && $middle_name->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        Отчество:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if($user->middle_name)
                                                            {{$user->middle_name}}
                                                            @else
                                                            &mdash;
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isset($sex) && $sex->value && $sex->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        Пол:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if(isset($user->sex))
                                                                @if($user->sex == "1")
                                                                    Мужской
                                                                @endif
                                                                @if($user->sex == "2")
                                                                    Женский
                                                                    @endif
                                                                    @else
                                                                    &mdash;
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @set('native_city_id', get_profile_field($profileFields, 'native_city_id'))

                                            @if(isset($native_city_id) && $native_city_id->value && $native_city_id->value['visibility'] != 2)
                                                <h5><strong>Контактные данные</strong></h5>
                                            @endif

                                            @if(isset($native_city_id) && $native_city_id->value && $native_city_id->value['visibility'] != 2)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        Место рождения:
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="overflowed">
                                                            @if($user->native_city)
                                                            {{$user->native_city ? native_city($user->native_city) : ''}}
                                                            @else
                                                            &mdash;
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($fieldGroupsArray))
                                <div class="row more-details">
                                    <hr>
                                    @foreach(array_chunk($fieldGroupsArray, 2, true) as $i => $groupArray)
                                        <div class="col-xs-6">
                                            @foreach($groupArray as $group)
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5><strong>{{$group['group']->name}}</strong></h5>
                                                        @if(!empty($group['fields']))
                                                            @foreach($group['fields'] as $field)
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="overflowed">{{$field->name}}</div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="overflowed">
                                                                            @if(!empty($field->value['value']))
                                                                            {{$field->value['value']}}
                                                                            @else
                                                                            &mdash;
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row show-more-button">
                                    <br>
                                    <button type="button" class="btn btn-primary btn-lg btn-xlg btn-show-more">Показать
                                        больше
                                    </button>
                                </div>
                                <div class="row show-less-button">
                                    <br>
                                    <button type="button" class="btn btn-primary btn-lg btn-xlg btn-show-less">Закрыть
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @section('scripts')
                    <script>

                        $(function () {
                            $(document).on('click', '.btn-show-more', function () {
                                $('.show-more-button').hide();
                                $('.show-less-button').show();
                                $('.more-details').fadeIn(500);
                                return false;
                            });

                            $(document).on('click', '.btn-show-less', function () {
                                $('.show-more-button').show();
                                $('.show-less-button').hide();
                                $('.more-details').fadeOut(500);
                                return false;
                            });
                        });

                    </script>
                @endsection

                @if(isset($activities) && count($activities) > 0)
                    <div class="profile-section">
                        <div class="clearfix">
                            <h3><strong>Активность</strong></h3>
                        </div>

                        <div class="comments-list comments-gray">
                            @foreach($activities as $activity)
                                @include(theme('activity.' . get_activity_template($activity)))
                            @endforeach
                            {{$activities->links()}}
                        </div>

                        <div class="comments-load-more">
                            <a href=" {{$activities->nextPageUrl()}}">
                                <button type="button" class="btn btn-primary btn-lg btn-xlg">
                                    Следующая страница
                                </button>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
