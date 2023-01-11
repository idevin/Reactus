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
                    <th>Название</th>
                    <th>Описание</th>
                    <th></th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->name)
                                    {{$item->name}}
                                @endif

                            </td>
                            <td>
                                @if($item->description)
                                    {!! $item->description !!}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cms.billing.tariffs.edit', ['tariff_id' => $item->id], false) }}" class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('cms.billing.tariffs.destroy', ['tariff_id' => $item->id], false) }}" class="btn btn-danger btn-sm"
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