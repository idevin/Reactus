@extends(session('theme'))

@section('content')

<div class="lost-password">
  <div class="container">

  	@include(theme('includes.breadcrumbs'))

    <h2 class="main-heading">ЗАБЫЛИ ПАРОЛЬ</h2>

    <div class="row">
      <div class="col-md-12">
        <div class="content-body">
          <p>
            <strong>Введите данные для востановления</strong>
          </p>

          <form id="lost-form" novalidate>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="login" class="control-label">Логин или E-mail или Телефон</label>

                  <input type="text" id="login" class="form-control input-lg" name="login"
                         data-validation="required"
                         data-validation-error-msg="Заполните поле">

                </div>

                {!! Recaptcha::render([ 'lang' => 'ru' ]) !!}
              </div>
            </div>

            <div class="content-footer clearfix">
              <div class="lost-password-submit pull-left">
                <button type="submit" class="btn btn-lg btn-xlg btn-primary" data-redirect-url="{{ route('login') }}">
                  Восстановить пароль
                </button>
              </div>

              {{-- <img src="assets/img/captcha.png"> --}}
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
