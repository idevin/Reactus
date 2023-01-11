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
                        @include('cms.partials.sort_field', ['route' => 'objects.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'objects.index', 'alias' => 'name', 'name' => 'Название'])
                    </th>
                    <th>Действия</th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                {{$item->name}}
                            </td>
                            <td style="white-space: nowrap;">

                                <a href="{{ route('objects.edit', ['object' => $item->id], false) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('objects.destroy', ['object' => $item->id], false) }}"
                                   class="btn btn-danger btn-sm"
                                   data-method="delete" data-confirm="Точно удалить ?"><i
                                            class="fa fa-times"></i></a>
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

                @include('cms.objects.modals')

            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif
        </div>
    </div>
@stop