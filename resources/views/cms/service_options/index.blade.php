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
                    <th>Сервис</th>
                    <th>Тип</th>
                    <th>Действия</th>
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
                                {{$item->service->name}}
                            </td>
                            <td>
                                {{\App\Models\BillingServiceOptions::$types[$item->increment_type]}}
                            </td>
                            <td>
                                <a href="{{ route('cms.billing.service_options.edit', ['service_options' => $item->id]) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('cms.billing.service_options.destroy', ['service_options' => $item->id]) }}"
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