@if (Auth::check())
<!-- authorized user -->
<div class="navbar-user navbar-user-sm dropdown">
  <div id="personal-dropdown" class="navbar-user-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <div class="navbar-user-av">
      <div class="navbar-user-av-block">
        <img src="http://placehold.it/40x40" width="40" height="40" alt=""/>
        <span class="notification-counter">33</span>
      </div>
    </div>
    <div class="navbar-user-info">
      <p class="navbar-user-name">{{Auth::user()->username}}</p>

      <p class="navbar-user-role">Писатель 20 lvl</p>
    </div>
  </div>

  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="personal-dropdown">
    <ul class="navbar-account">
      <li><a href="#" class="navbar-account-item">ИСТОРИЯ</a></li>
      <li><a href="#" class="navbar-account-item">ЛОГИ</a></li>
      <li><a href="#" class="navbar-account-item">ЛИЧНЫЙ КАБИНЕТ</a></li>
      <li><a href="#" class="navbar-account-item">ДРУЗЬЯ</a></li>
      <li><a href="#" class="navbar-account-item">ИЗБРАННОЕ</a></li>
      <li><a href="#" class="navbar-account-item">МОЙ ДИСК</a></li>
      <li><a href="#" class="navbar-account-item js-sign-out">ВЫХОД</a></li>
    </ul>
  </div>
</div>
<!-- authorized user end -->
@else
<!-- unauthorized user -->
<div class="navbar-auth-dropdown dropdown js-dropdown-auth">
  <button id="auth-dropdown" class="btn btn-success btn-auth" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="icon icon-navbar-profile"></span>
    АВТОРИЗАЦИЯ
  </button>
  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="auth-dropdown">
    <form action="#" method="post" id="auth-form" class="js-auth-form" novalidate>
      <div class="form-group no-m">
        <input type="text" class="form-control input-lg" name="login" placeholder="E-mail/Телефон/Логин"
             data-validation="required"
             data-validation-error-msg="Заполните поле"
              />
      </div>
      <div class="form-group no-m">
        <input type="password" class="form-control input-lg" name="password" placeholder="Пароль"
               data-validation="required"
               data-validation-error-msg="Введите пароль" />
      </div>

      <div class="navbar-auth-buttons">
        <button type="submit" class="btn btn-primary btn-lg btn-login">ВОЙТИ</button>
        <button type="button" class="btn btn-success btn-lg btn-register" data-toggle="modal" data-target="#reg-step1">
          РЕГИСТРАЦИЯ
        </button>
      </div>

      <a href="{{ route('password.reset') }}"><small>Забыли пароль?</small></a>

      <div class="navbar-auth-social">
        <a href="#" class="btn btn-lg btn-fb">FACEBOOK</a>
        <a href="#" class="btn btn-lg btn-vk">ВКОНТАКТЕ</a>
        <a href="#" class="btn btn-lg btn-tw">TWITTER</a>
        <a href="#" class="btn btn-lg btn-gp">GOOGLE+</a>
      </div>
    </form>
  </div>
</div>
<!-- unauthorized user end -->

@endif