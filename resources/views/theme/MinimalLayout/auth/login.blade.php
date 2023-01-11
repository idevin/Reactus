@extends(session('theme'))

@section('content')
<div class="lost-password">
  <div class="container">
    @include(theme('includes.breadcrumbs'))

    <h2 class="main-heading">АВТОРИЗАЦИЯ</h2>

    <div class="row">
      <div class="col-md-12">
        <div class="content-body">
          <form class="js-auth-form" novalidate>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="auth-login" class="control-label">Логин или E-mail или Телефон</label>

                  <input type="text" class="form-control input-lg" id="auth-login" name="login"
                         data-validation="required"
                         data-validation-error-msg="Заполните поле"
                    />
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="auth-password" class="control-label">Пароль</label>

                  <input type="password" class="form-control input-lg" id="auth-password" name="password"
                         data-validation="required"
                         data-validation-error-msg="Введите пароль" />
                </div>
              </div>
            </div>

            <div class="content-footer">
              <button type="submit" class="btn btn-lg btn-success">ВОЙТИ</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
