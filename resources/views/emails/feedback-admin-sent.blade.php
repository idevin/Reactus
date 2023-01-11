@include('emails/_header')

Было отправлено сообщение с сайта <a href="http://{{$site->domain}}" target="_blank">{{$site->domain}}</a>!

<br>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>

@foreach($fields as $data)
    @if(!empty($data['name']) && !empty($data['value']))
        <b>{{$data['name']}}</b>: &nbsp; {{$data['value']}}
        <hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>
    @endif
@endforeach

<br>

@if($user)

    <hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>

    Отправил пользователь {{username($user)}} <br>
    @if(!empty($user->email))
        <b>Email:</b> {{$user->email}}
    @endif

    @if(!empty($user->phone))
        <b>>Телефон:</b> {{$user->phone}}
    @endif
@endif


@if($name || $email || $phone)
    <hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>
@endif

@if($name)
    <b>Имя</b>: &nbsp; {{$name}} <br>
@endif

@if($email)
    <b>E-mail</b>: &nbsp; {{$email}} <br>
@endif

@if($phone)
    <b>Телефон</b>: &nbsp; {{$phone}} <br>
@endif


@include('emails/_footer')