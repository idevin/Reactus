@extends('cms.layouts.master')

@section('title')
    <title>cms. &bull; Панель управления &bull; {{ $title }}</title>
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
                        @include('cms.partials.sort_field', ['route' => 'templates.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'templates.index', 'alias' => 'name', 'name' => 'Имя'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'templates.index', 'alias' => 'alias', 'name' => 'Alias'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'templates.index', 'alias' => 'default', 'name' => 'По умолчанию'])
                    </th>
                    <th></th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->alias }}</td>
                            <td>
                                @if($item->default == 1)
                                    Да
                                    @else
                                    &mdash;
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('templates.edit', ['template' => $item->id]) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('templates.destroy', ['template' => $item->id]) }}"
                                   class="btn btn-danger btn-sm"
                                   data-method="delete" data-confirm="Точно удалить ?"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>
@stop