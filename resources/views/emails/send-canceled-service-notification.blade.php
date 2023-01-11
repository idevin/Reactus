@include('emails/_header')


<p>
    У Вас окончились сервисы на сайте {{idnToUtf8($_site->domain)}}
</p>

<hr style="width: 100%; height: 1px; background-color: #f1f3f5; border: 0; margin: 10px auto;"/>

<ul>
    @foreach($services as $service)
        <li>
            <b>{{$service->service->name}}</b> <br>
            <sup>{!! $service->service->description !!}</sup>
        </li>
    @endforeach
</ul>

@include('emails/_footer')