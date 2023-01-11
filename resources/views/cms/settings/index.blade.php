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
                        @include('cms.partials.sort_field', ['route' => 'settings.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        Сайт
                    </th>
                    <th>
                        Действия
                    </th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        @if($item->site)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{idnToUtf8($item->site->domain)}}</td>
                                <td>
                                    <a href="{{ route('settings.edit', ['setting' => $item->id]) }}" class="btn btn-default"><i
                                                class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('settings.destroy', ['setting' => $item->id]) }}" class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить ?"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="col-lg-12">
                    @if(count($fields) > 10)
                        @include('cms.partials.pagination')
                    @endif
                </div>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>
@stop