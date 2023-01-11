@extends('StaticDefaultLayout')

@section('content')
    <div class="profile">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <h2 class="main-heading">О себе</h2>

                    <div class="content-body">
                        <div class="profile-body">
                            <div class="profile-section bordered">
                                @include(theme('includes.breadcrumbs'))
                            </div>
                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    @include(theme('profile.group_visibility_user'))
                                    <h3><strong>Основные</strong></h3>
                                </div>
                                <form class="edit-profile-form">
                                    <div class="clearfix">
                                        <div class="row">

                                            <div class="alert alert-success" style="display: none;" data-group_id="-1" role="alert"></div>

                                            <div class="alert alert-danger hidden" data-group_id="-1" role="alert"></div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'first_name', 'field' => get_profile_field($profileFields, 'first_name')])

                                                    <label for="p-firstName" class="control-label">Имя</label>

                                                    <input type="text" class="form-control input-lg" id="p-firstName" name="first_name"
                                                           value="{{$user->first_name}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'last_name', 'field' => get_profile_field($profileFields, 'last_name')])

                                                    <label for="p-lastName" class="control-label">Фамилия</label>

                                                    <input type="text" class="form-control input-lg" id="p-lastName" name="last_name"
                                                           value="{{$user->last_name}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'middle_name', 'field' => get_profile_field($profileFields, 'middle_name')])

                                                    <label for="p-middleName" class="control-label">Отчество</label>

                                                    <input type="text" class="form-control input-lg" id="p-middleName" name="middle_name"
                                                           value="{{$user->middle_name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'sex', 'field' => get_profile_field($profileFields, 'sex')])
                                                    <label for="p-sex" class="control-label">Пол</label>

                                                    <select name="sex" id="p-sex">
                                                        <option value="" @if($user->sex == null)selected="selected"@endif>
                                                            Выберите пол...
                                                        </option>
                                                        <option value="1" @if($user->sex == 1)selected="selected"@endif>Мужской</option>
                                                        <option value="2" @if($user->sex == 2)selected="selected"@endif>Женский</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'birthday', 'field' => get_profile_field($profileFields, 'birthday')])
                                                    <label class="control-label">Дата рождения</label>

                                                    @section('scripts')
                                                        <script>
                                                            $(function () {
                                                                $(".js-datetimepicker2").datetimepicker({
                                                                    format: "DD.MM.YYYY HH:mm"
                                                                });
                                                            });
                                                        </script>
                                                    @endsection

                                                    <div class="input-group date js-datetimepicker2">
                                                        <input name="birthday" type="text" class="form-control input-lg"
                                                               value="{{(int)$user->birthday > 0 ? date('d.m.Y H:i', strtotime($user->birthday)) : null}}">

                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    @include(theme('profile.field_visibility'), ['fieldAlias' => 'native_city_id', 'field' => get_profile_field($profileFields, 'native_city_id')])
                                                    <label for="p-birthplace" class="control-label">Место рождения</label>

                                                    <input name="native_city"
                                                           value="{{$user->native_city ? native_city($user->native_city) : ''}}"
                                                           type="text" class="form-control input-lg has-city-autocomplete" id="p-birthplace">

                                                    <input name="native_city_id" value="{{$user->native_city ? $user->native_city->id : ''}}"
                                                           type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <button type="button" class="edit-profile-button edit btn btn-success btn-lg
                                            btn-block">Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            @if(!empty($fieldGroupsArray))
                                @foreach($fieldGroupsArray as $group)

                                    <div class="profile-section bordered">
                                        <div class="clearfix">

                                            @include(theme('profile.group_visibility'),['userGroup' => $group['user_group'], 'group' => $group['group']])


                                            <h3><strong>{{$group['group']->path}}</strong></h3>

                                        </div>


                                        @if($group['group']->multi_field == 1)
                                            <div class="multi_field" data-id="{{$group['group']->id}}">
                                                @include(theme('profile.multi-fields'))
                                            </div>
                                        @endif

                                        <div class="alert alert-success" style="display: none;" data-group_id="{{$group['group']->id}}" role="alert"></div>

                                        <div class="alert alert-danger hidden" data-group_id="{{$group['group']->id}}" role="alert"></div>

                                        @if(!empty($group['fields']))
                                            <form action="" class="abstract-form" enctype="multipart/form-data">
                                                <input type="hidden" name="field_group_id" value="{{$group['group']->id}}">

                                                <div class="clearfix">
                                                    <div class="row">
                                                        @foreach($group['fields'] as $field)
                                                            <div class="col-xs-6">
                                                                <div class="form-group">
                                                                    @include(theme('profile.field_visibility'), ['field' => $field, 'fieldAlias' => $field->alias, 'group' => $group, 'fieldUserGroups' => $fieldUserGroups])

                                                                    <label for="p-{{$field->name}}"
                                                                           class="control-label">{{$field->name}}</label>

                                                                    @include(theme('profile.input'))
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-4">
                                                        <button type="submit" class="btn btn-success btn-lg btn-block">
                                                            @if($group['group']->multi_field == 0)
                                                                Сохранить
                                                            @else
                                                                Добавить
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                @include(theme('profile.profile-right-bar'), ['user' => $user])
            </div>
        </div>
    </div>
@endsection
