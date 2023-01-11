@extends('StaticDefaultLayout')

@section('content')
    <div class="profile">
        <div class="container">
            @include(theme('includes.breadcrumbs'))
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <h2 class="main-heading">Безопасность</h2>

                    <div class="content-body">
                        <div class="profile-body">
                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <h3><strong>Имя, фамилия и никнейм</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <form class="save-personal">
                                        <div class="row">

                                            <div class="alert alert-success hidden" role="alert"></div>
                                            <div class="alert alert-danger error hidden" role="alert"></div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-lastName" class="control-label">Фамилия</label>

                                                    <input type="text"
                                                           class="form-control input-lg"
                                                           id="p-lastName"
                                                           value="{{$user->last_name}}"
                                                           name="last_name">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-firstName" class="control-label">Имя</label>

                                                    <input type="text" class="form-control input-lg" id="p-firstName"
                                                           name="first_name"
                                                           value="{{$user->first_name}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-middleName" class="control-label">Никнейм</label>

                                                    <input type="text"
                                                           class="form-control input-lg"
                                                           id="p-username"
                                                           name="username"
                                                           value="{{$user->username}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <button type="submit"
                                                        class="edit btn btn-success btn-lg btn-block save-personal-button">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <hr>

                                    <div class="clearfix">
                                        <h3><strong>Изменить пароль</strong></h3>
                                    </div>
                                    <form class="save-password">
                                        <div class="row">

                                            <div class="alert alert-success hidden" role="alert"></div>
                                            <div class="alert alert-danger error hidden" role="alert"></div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-lastName" class="control-label">Старый пароль</label>

                                                    <input type="password" class="form-control input-lg"
                                                           id="p-password_old" value=""
                                                           name="password_old">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-firstName" class="control-label">Новый пароль</label>

                                                    <input type="password" class="form-control input-lg"
                                                           id="p-password_new" name="password_new"
                                                           value="">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-middleName" class="control-label">Повторите
                                                        пароль</label>

                                                    <input type="password" class="form-control input-lg"
                                                           id="p-password_new_confirm"
                                                           name="password_new_confirm"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <button type="submit"
                                                        class="edit btn btn-success btn-lg btn-block save-password-button">
                                                    Сохранить
                                                </button>
                                            </div>
                                            <div class="col-xs-8">
                                                <a href="/password/reset" style="line-height:49px;">Забыли
                                                    пароль?</a>
                                            </div>
                                        </div>
                                    </form>

                                    <hr>

                                    <div class="clearfix">
                                        <h3><strong>Изменить адрес электронной почты</strong></h3>
                                    </div>

                                    <form class="save-email">
                                        <div class="row">

                                            <div class="alert alert-success hidden" role="alert"></div>
                                            <div class="alert alert-danger error hidden" role="alert"></div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-lastName" class="control-label">Введите текущий email</label>

                                                    <input type="text" class="form-control input-lg"
                                                           id="p-email_old"
                                                           value=""
                                                           name="email_old">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-firstName" class="control-label">Новый email</label>

                                                    <input type="text" class="form-control input-lg" id="p-email_new"
                                                           name="email_new"
                                                           value="">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-middleName" class="control-label">Повторите
                                                        email</label>

                                                    <input type="text" class="form-control input-lg"
                                                           id="p-email_new_confirm"
                                                           name="email_new_confirm"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <button type="submit"
                                                        class="edit btn btn-success btn-lg btn-block save-email-button">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <hr>

                                    <div class="clearfix">
                                        <h3><strong>Изменить телефон</strong></h3>
                                    </div>

                                    <form class="save-phone">
                                        <div class="row">

                                            <div class="alert alert-success hidden" role="alert"></div>
                                            <div class="alert alert-danger error hidden" role="alert"></div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-lastName" class="control-label">Текущий номер</label>

                                                    <input type="text" class="form-control input-lg" id="p-phone_old"
                                                           name="phone_old">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-firstName" class="control-label">Новый номер</label>

                                                    <input type="text" class="form-control input-lg" id="p-phone_new"
                                                           name="phone_new"
                                                           value="">
                                                </div>
                                            </div>

                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label for="p-middleName" class="control-label">Повторите
                                                        номер</label>

                                                    <input type="text" class="form-control input-lg"
                                                           id="p-phone_new_confirm"
                                                           name="phone_new_confirm"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <button type="submit"
                                                        class="edit btn btn-success btn-lg btn-block save-phone-button">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include(theme('profile.profile-right-bar'), ['user' => $user])
            </div>
        </div>
    </div>
@endsection