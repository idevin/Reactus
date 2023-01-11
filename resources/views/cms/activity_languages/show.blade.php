@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @include('cms.partials.flash')

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Браузер</h1>
            @if(!empty($item['browser']))
                @foreach($item['browser'] as $key => $value)
                    @if(is_string($value))
                        <b>{{$key}}:</b> {{strip_tags($value)}} <br>
                        @endif
                        @endforeach
                        @else
                        &mdash;
                    @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Запрос</h1>
            @if(!empty($item['request']))
                @foreach($item['request'] as $key => $value)
                    @if(is_string($value))
                        <b>{{$key}}:</b> {{strip_tags($value)}} <br>
                        @endif
                        @endforeach
                        @else
                        &mdash;
                    @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Окружение</h1>
            @if(!empty($item['env']))
                @foreach($item['env'] as $key => $value)
                    @if(is_string($value))
                        <b>{{$key}}:</b> {{strip_tags($value)}} <br>
                        @endif
                        @endforeach
                        @else
                        &mdash;
                    @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Сервер</h1>
            @if(!empty($item['server']))
                @foreach($item['server'] as $key => $value)
                    @if(is_string($value))
                        <b>{{$key}}:</b> {{strip_tags($value)}} <br>
                    @endif
                @endforeach
                    @else
                    &mdash;
            @endif
        </div>
    </div>
@stop