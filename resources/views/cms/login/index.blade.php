@extends('cms.layouts.login')

@section('content')

    <div class="col-md-10">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Войти</h3>
            </div>
            <div class="panel-body">

                @include('cms.partials.errors')

                {{ Form::open(['route' => ['login.auth', false], 'method' => 'post', 'theme' => 'bootstrap-vertical', 'absolute' => false]) }}
                <fieldset>
                    <div class="form-group">
                        {{ Form::text('username', '', ['class' => 'form-control', 'placeholder' => 'Login']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => "Password"]) }}
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox">Запомнить меня
                        </label>
                    </div>
                    {{ Form::hidden('r', request('r')) }}
                    {{ Form::submit('OK', ['class' => 'btn btn-primary btn-lg btn-block']) }}
                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
