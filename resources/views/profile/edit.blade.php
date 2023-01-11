<?php $profile = true; ?>

@extends('layout')

@section('content')
    <div class="profile">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <h2 class="main-heading">О себе</h2>

                    <div class="content-body">
                        <div class="profile-body">
                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <div class="profile-section-action pull-right">
                                        <div class="dropdown profile-visibility">
                                            <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Видно всем
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                aria-labelledby="dLabel">
                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3><strong>Основные</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <div class="profile-field-visibility pull-right">
                                                    <div class="dropdown profile-visibility">
                                                        <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Видно всем
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                            aria-labelledby="dLabel">
                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <label for="p-lastName" class="control-label">Фамилия</label>

                                                <input type="text" class="form-control input-lg" id="p-lastName" value="{{$user->last_name}}"
                                                       name="last_name">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <div class="profile-field-visibility pull-right">
                                                    <div class="dropdown profile-visibility">
                                                        <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Видно всем
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                            aria-labelledby="dLabel">
                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <label for="p-firstName" class="control-label">Имя</label>

                                                <input type="text" class="form-control input-lg" id="p-firstName" name="first_name"
                                                       value="{{$user->first_name}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-middleName" class="control-label">Отчество</label>

                                                <input type="text" class="form-control input-lg" id="p-middleName" name="middle_name"
                                                       value="{{$user->middle_name}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-sex" class="control-label">Пол</label>

                                                <select name="sex" id="p-sex" style="display: none;">
                                                    <option value="1">Мужской</option>
                                                    <option value="0">Женский</option>
                                                </select>
                                                <!--
                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title="" id="p_sex_chosen"><a class="chosen-single"
                                                                                                         tabindex="-1"><span>Мужской</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Дата рождения</label>

                                                <div class="input-group date  js-datetimepicker">
                                                    <input name="birthday" type="text" class="form-control input-lg" value="{{(int)$user->birthday > 0 ? $user->birthday : ''}}">

                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-birthplace" class="control-label">Место рождения</label>

                                                <input name="native_city" value="{{$user->native_city ? $user->native_city->name : ''}}" type="text" class="form-control input-lg" id="p-birthplace">

                                                <input name="native_city_id" value="{{$user->native_city ? $user->native_city->id : ''}}" type="hidden">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <button type="button" class="edit btn btn-success btn-lg btn-block">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <div class="profile-section-action pull-right">
                                        <div class="dropdown profile-visibility">
                                            <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Видно всем
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                aria-labelledby="dLabel">
                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3><strong>Астрология</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-zodiac" class="control-label">Знак зодика</label>

                                                <input type="text" class="form-control input-lg" id="p-zodiac">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-fangshui" class="control-label">Китайский феншуй</label>

                                                <input type="text" class="form-control input-lg" id="p-fangshui">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-druid" class="control-label">Друиды</label>

                                                <input type="text" class="form-control input-lg" id="p-druid">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <div class="profile-section-action pull-right">
                                        <div class="dropdown profile-visibility">
                                            <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Видно всем
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                aria-labelledby="dLabel">
                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3><strong>Семья</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-marital" class="control-label">Семейное положение</label>

                                                <select id="p-marital" style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title="" id="p_marital_chosen"><a class="chosen-single"
                                                                                                             tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-partner" class="control-label">Партнер</label>

                                                <input type="text" class="form-control input-lg" id="p-partner">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-parents" class="control-label">Родители</label>

                                                <input type="text" class="form-control input-lg" id="p-parents">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-siblings" class="control-label">Братья \ Сестры</label>

                                                <input type="text" class="form-control input-lg" id="p-siblings">
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label for="p-children" class="control-label">Дети</label>

                                                <input type="text" class="form-control input-lg" id="p-children">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <div class="profile-section-action pull-right">
                                        <div class="dropdown profile-visibility">
                                            <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Видно всем
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                aria-labelledby="dLabel">
                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3><strong>Образование</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Тип образования</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Страна</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Область</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Город</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Учебное заведение</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Дата окончания</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <button type="button" class="btn btn-success btn-lg btn-block">Добавить заведение</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="profile-section bordered">
                                <div class="clearfix">
                                    <div class="profile-section-action pull-right">
                                        <div class="dropdown profile-visibility">
                                            <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Видно всем
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                aria-labelledby="dLabel">
                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                </li>

                                                <li class="profile-visibility-menu-item">
                                                    <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h3><strong>Карьера</strong></h3>
                                </div>

                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Тип образования</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Страна</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <div class="profile-field-visibility pull-right">
                                                    <div class="dropdown profile-visibility">
                                                        <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Видно всем
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                            aria-labelledby="dLabel">
                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <label class="control-label">Область</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Город</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <div class="profile-field-visibility pull-right">
                                                    <div class="dropdown profile-visibility">
                                                        <button type="button" class="btn btn-link btn-success profile-visibility-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Видно всем
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-right profile-visibility-menu  js-profile-visibility"
                                                            aria-labelledby="dLabel">
                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-success">Видно всем</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-danger">Не видно</button>
                                                            </li>

                                                            <li class="profile-visibility-menu-item">
                                                                <button type="button" class="btn btn-link btn-warning">Выбрать</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <label class="control-label">Учебное заведение</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-4">
                                            <div class="form-group">
                                                <label class="control-label">Дата окончания</label>

                                                <select style="display: none;">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                </select>

                                                <div class="chosen-container chosen-container-single chosen-container-single-nosearch"
                                                     style="width: 260px;" title=""><a class="chosen-single" tabindex="-1"><span>1</span>

                                                        <div><b></b></div>
                                                    </a>

                                                    <div class="chosen-drop">
                                                        <div class="chosen-search"><input type="text" autocomplete="off" readonly=""></div>
                                                        <ul class="chosen-results"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <button type="button" class="btn btn-success btn-lg btn-block">Добавить заведение</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('partials.profile-right-bar', ['user' => Auth::user()])
            </div>
        </div>
    </div>
@endsection