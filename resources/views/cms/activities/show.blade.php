@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])
            @include('cms.partials.flash')

            <h1 class="page-header">{{ $title }}</h1>

            <h3> @if(!empty($item->activityLanguages->keyBy('lang')) && isset($item->activityLanguages->keyBy('lang')[\Lang::getLocale()]))
                    {{$item->activityLanguages->keyBy('lang')[\Lang::getLocale()]->translated}}
                @else
                    {{__($item['title'])}}
                @endif

     ({{$item['platform']}},
                    {{$item['browser_string']}}, {{$item['device_type']}})
            </h3>
            <hr>

            @foreach($item['server'] as $key => $value)
                <div class="row">
                    <div class="col-lg-2">{{$key}}</div>
                    <div class="col-lg-10">{{$value}}</div>
                </div>
            @endforeach

            <hr>

            @foreach($item['location'] as $key => $value)
                <div class="row">
                    <div class="col-lg-2">{{$key}}</div>
                    <div class="col-lg-10">{{$value}}</div>
                </div>
            @endforeach

            @if(!empty($item['error']))
                <hr>
                <h4>{{$item['error'][0]['message']}}</h4>
                <hr>

                @foreach($item['error'][0]['trace'] as $data)
                    @if(!empty($data['file']) && !empty($data['line']))
                        @if(preg_match('/app\//', $data['file']))
                            <b>
                                @endif
                                file: {{$data['file']}}
                                <br>
                                line: {{$data['line']}}
                                <hr>
                                @if(preg_match('/app\//', $data['file']))
                            </b>
                        @endif
                    @endif
                @endforeach
            @endif

        </div>
    </div>
@stop