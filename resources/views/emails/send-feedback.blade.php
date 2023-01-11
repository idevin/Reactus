@include('emails/_header')

<h6>Пользователь</h6>

<p>
    <b>ФИО:</b> {{$clientName}}
</p>

<p>
    <b>Email:</b> {{$clientEmail}}
</p>

<p>
    <b>Телефон:</b> {{$clientPhone}}
</p>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;" />

<h6>Данные</h6>

@foreach($readyFields as $field)
    <p>
        <b>{{$field->field->name}}:</b> {{$field->field->value}}
    </p>
@endforeach

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;" />

<h6>Сообщение:</h6>

{{$clientMessage}}

@include('emails/_footer')

