@include('emails/_header')

Вы отправили обратную связь сайте <a href="http://{{$domain}}" target="_blank">{{$domain}}</a>!

<br>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>

Ваши личные данные:

<br>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>

Логин: {{$user->username}} <br>
Пароль: {{$password}} <br>
Персональная страница: <a href="http://{{$user->domain}}" target="_blank">{{$user->domain}}</a>


@include('emails/_footer')