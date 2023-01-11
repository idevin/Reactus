@include('emails/_header')

<p>
    Код для восстановления пароля: {{$token}}
</p>

@include('emails/_footer')