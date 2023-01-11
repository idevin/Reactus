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

            @if (count($fields) > 0)
                <table class="table table-hover">
                    <thead>
                    <th>ID</th>
                    <th>Дата/Время начала</th>
                    <th>Логин</th>
                    <th>E-mail</th>
                    <th>Телефон</th>
                    <th>Подписка</th>
                    <th>Дата окончания</th>
                    <th>Сайт</th>
                    <th>Управление</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{$item->human_starts_at}}
                            </td>
                            <td>
                                {{username($item->user)}}
                            </td>
                            <td>
                                @if($item->user->email)
                                {{$item->user->email}}
                                @else
                                &mdash;
                                @endif

                            </td>
                            <td>
                                @if($item->user->phone)
                                {{$item->user->phone}}
                                @else
                                &mdash;
                                @endif
                            </td>
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{$item->human_ends_at}}
                            </td>
                            <td>
                                <a href="{{$item->site->url}}" target="_blank">{{$item->site->url}}</a>
                            </td>
                            <td>
                                <a href="{{ route('subscriptions.edit', ['subscription' => $item->id]) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                @if(!$item->trashed())
                                    <a href="{{ route('subscriptions.destroy', ['subscription' => $item->id]) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить ?"><i class="fas fa-times"></i></a>
                                @else
                                    <a href="{{ route('subscriptions.undelete', ['subscriptions' => $item->id]) }}"
                                       class="btn deleteSite" title="Восстановить"><i class="fa fa-check"
                                                                                      aria-hidden="true"></i></a>
                                    <a href="{{ route('subscriptions.destroyForever', ['subscriptions' => $item->id]) }}"
                                       data-method="delete"
                                       data-confirm="Точно удалить ?"
                                       class="btn deleteSite" style="padding: 0;"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i></a>
                                @endif
                            </td>
                        </tr>
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