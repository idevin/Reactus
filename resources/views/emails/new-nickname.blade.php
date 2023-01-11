@include('emails/_header')

<p>
    Вы успешно обновили имя пользователя!
</p>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;" />

<p>
    <b>Ваш новый псевдоним:</b> {{$username}}
</p>

<p>
    <b>Ваш URL персонального сайта:</b> {{$domain}}
</p>
@include('emails/_footer')

