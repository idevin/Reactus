@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            <div class="form-group">
                {!! $filter !!}
            </div>

            @include('cms.partials.flash')

            @if (count($grouped) > 0)
                <table class="table table-hover">
                    <thead style="background-color: #c8c8c83d;">
                    <th>ID</th>
                    <th>Пользователь</th>

                    <th style="white-space: nowrap;">
                        Дата / Время
                    </th>
                    <th>Домен (url)</th>
                    <th>Обьект</th>
                    <th>Действие</th>
                    <th>Комментарий</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($grouped as $id => $data)
                        @if(count($data) > 0)
                            <div class="list-item">
                                @foreach ($data['sessions'] as $j)
                                    <tr>
                                        <td>
                                            @if(!empty($j['session_name']))
                                                {{$j['session_name']}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($j['user'])
                                                <a href="{{route('cms.users.edit', ['user_id' => $j['user']->id])}}"
                                                   target="_blank">{{ username($j['user']) }}</a>
                                            @else
                                                Аноним
                                            @endif
                                        </td>
                                        <td>
                                            {{getFormatedDate($j['created_at'], 'ru', 'j F Yг. в H:i')}}
                                        </td>
                                        <td>
                                            @if($j['domain'])
                                                @php
                                                    $urlName = parse_url($j['full_url']);
                                                    $urlName = truncate_content($urlName['scheme'] . '://' . $urlName['host'] . $urlName['path'], 40);
                                                @endphp
                                                <a href="{{$j['full_url']}}" target="_blank">{{$urlName}}</a>
                                            @else
                                                {{$urlName}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($j['error']))
                                                <span style="color: red; ">
                                                    @endif
                                                    {{__($j['object_string'])}}
                                                    @if(!empty($j['error']))
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($j->activityLanguages->keyBy('lang')) && isset($j->activityLanguages->keyBy('lang')[\Lang::getLocale()]))
                                                {{$j->activityLanguages->keyBy('lang')[\Lang::getLocale()]->translated}}
                                            @else
                                                {{__($j['title'])}}
                                            @endif

                                            @if($j['is_api'])
                                                (API)
                                            @endif

                                            @if($j['is_system'])
                                                (SYS)
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($j['platform']))
                                                {{$j['platform']}},
                                            @endif

                                            @if(!empty($j['device_type']))
                                                {{$j['device_type']}},
                                            @endif

                                            @if(!empty($j['browser_string']))
                                                {{$j['browser_string']}},
                                            @endif

                                            @if(!empty($j['location_country']))
                                                {{$j['location_country']}},
                                            @endif

                                            @if(!empty($j['location_city']))
                                                {{$j['location_city']}}
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a href="{{ route('activities.show', ['activity' => $j['id']]) }}"
                                               class="btn btn-default"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </div>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-12">
                        @include('cms.partials.pagination')
                    </div>
                </div>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif

        </div>
    </div>
@stop