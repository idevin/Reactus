@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @if (count($errors) > 0)
                @include('cms.partials.errors')
            @endif

            {{ Form::model($user, ['url' => route('cms.users.update', ['user_id' => $user->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

            <div class="form-group">
                @if($user->username)
                    {{username($user)}}
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('password', 'Пароль') }}
                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
            </div>

            <div class="form-group">
                {{ Form::label('password_confirmation', 'Пароль еще раз:') }}
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) }}
            </div>

            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) }}
            </div>

            <div class="form-group">
                {{ Form::label('phone', 'Телефон') }}
                {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) }}
            </div>
            <div class="form-group">
                {{ Form::label('balance', 'Баланс') }}
                {{ Form::number('balance', null, ['class' => 'form-control', 'id' => 'email']) }}
            </div>

            <div class="form-group">
                {{ Form::label('roles', 'Роли') }}
                {{ Form::select('roles[]',$roles, $user->roles->pluck('id')->toArray(), ['class' => 'form-control', 'id' => 'roles', 'multiple']) }}
            </div>

            <div class="form-group">
                {{ Form::label('domain', 'Персональный домен') }}

                <select class="form-control" id="user_id" name="domain">

                    @foreach($personalDomains as $index => $domainArray)

                        @if($domainArray['name'] == $user->domain)
                            <option value="{{$domainArray['name']}}"
                                    selected="selected">{{idnToUtf8($domainArray['name'])}}</option>
                        @else
                            <option value="{{$domainArray['name']}}">{{idnToUtf8($domainArray['name'])}}</option>
                        @endif

                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {{ Form::label('active', 'Активный пользователь?') }}
                {{ Form::checkbox('active', 1, ((int)$user->active == 1 ? true : false)) }}
            </div>

            <div class="form-group">
                {{ Form::label('superadmin', 'Супер-админ?') }}
                {{ Form::checkbox('superadmin', 1, ((int)$user->superadmin == 1 ? true : false)) }}
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>

            {{ Form::close() }}

        </div>
    </div>
@stop