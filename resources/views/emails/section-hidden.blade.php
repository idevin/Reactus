@include('emails/_header')

<p>
    Раздел <b>{{route_to_section($section)}}</b> стал закрытым.
</p>

<p>
    Скрытая ссылка для раздела: <b>{{route_to_section($section)}}</b>
</p>

<p>
    Чтобы открыть раздел для публичного просмотра, <a href="{{route_to_section($section)}}">отредактируйте его</a>
</p>

@include('emails/_footer')