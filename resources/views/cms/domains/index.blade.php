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
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'domains.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'domains.index', 'alias' => 'name', 'name' => 'Домен'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'domains.index', 'alias' => 'domain_type', 'name' => 'Тип'])
                    </th>
                    <th>Тематика</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        @if($item->site)
                            <tr style="background: aliceblue;">
                        @else
                            <tr>
                                @endif
                                <td>{{ $item->id }}</td>

                                <td>
                                    <a href="{{env('HTTP_X_SCHEME')}}://{{$item->name}}/"
                                       target="_blank">{{idnToUtf8($item->name)}}</a>
                                </td>
                                <td>

                                    {{$domainTypes[$item->domain_type]}}

                                    <br>
                                    <small>
                                        Дата создания: {{$item->created_at}}
                                    </small>
                                    @if($item->site)
                                        <br>
                                        <small>
                                            Дата создания сайта: {{$item->site->created_at}}
                                        </small>
                                        @if($item->site->user)
                                            <br>
                                            <small>
                                                Владелец: {{$item->site->user->email}}
                                            </small>
                                        @endif
                                    @endif
                                    <br>
                                    <small>
                                        @if($item->parent)
                                            <b>
                                                Родитель:
                                                {{idnToUtf8($item->parent->name)}}
                                            </b>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($item->domainThematic)
                                    {{idnToUtf8($item->domainThematic->name)}}
                                    @else
                                    &mdash;
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('domains.edit', ['domain' => $item->id], false) }}"
                                       class="btn btn-sm btn-default" title="Редактировать домен"><i
                                                class="fa fa-check"></i></a>

                                    @if($item->is_default != 1)
                                        <a href="{{ route('domains.destroy', ['domain' => $item->id], false) }}"
                                           class="btn btn-danger btn-sm" data-method="delete"
                                           data-confirm="Точно удалить ?"><i class="fa fa-times"></i></a>
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