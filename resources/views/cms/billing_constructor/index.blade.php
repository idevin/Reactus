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
                    <th>Название тарифа</th>
                    <th>Сервисы</th>
                    <th>Права</th>
                    <th>Управление</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)

                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{ $item->tariff->name }}

                            </td>
                            <td>
                                {{$item->service->name}}
                            </td>
                            <td>
                                @if($item->service->permissions)
                                    @foreach($item->service->permissions as $index => $permission)
                                        {{$permission->description}}
                                        @if(count($item->service->permissions)-1 != $index)
                                            |
                                            @endif
                                            @endforeach
                                            @else
                                            &mdash;
                                        @endif
                            </td>
                            <td>
                                <a href="{{ route('cms.billing.constructor.edit', ['constructor' => $item->id], false) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('cms.billing.constructor.destroy', ['constructor' => $item->id], false) }}"
                                   class="btn btn-danger btn-sm"
                                   data-method="delete" data-confirm="Точно удалить ?"><i class="fas fa-times"></i></a>
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