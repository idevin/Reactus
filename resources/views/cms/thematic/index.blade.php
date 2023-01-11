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
                        @include('cms.partials.sort_field', ['route' => 'thematic.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'thematic.index', 'alias' => 'name', 'name' => 'Название тематики'])
                    </th>
                    <th>Действия</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                <a href="{{ route('thematic.edit', ['thematic' => $item->id]) }}"
                                   class="btn btn-sm btn-default" title="Редактировать домен"><i
                                            class="fa fa-check"></i></a>

                                <a href="{{ route('thematic.destroy', ['thematic' => $item->id]) }}"
                                   class="btn btn-danger btn-sm" data-method="delete"
                                   data-confirm="Точно удалить ?"><i class="fa fa-times"></i></a>
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