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
                    <thead style="background-color: #c8c8c83d;">
                    <th>ID</th>
                    <th>Название</th>
                    <th>Перевод</th>
                    <th>Действие</th>
                    </thead>
                    <tbody>
                    @foreach($fields as $item)
                        <div class="list-item">
                            <tr>
                                <td>
                                    {{$item->id}}
                                </td>
                                <td>
                                    {{$item->activity_key}}
                                </td>
                                <td>
                                    {{$item->translated}}
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="{{ route('activity_languages.edit', ['activity_language' => $item->id]) }}"
                                       class="btn btn-default"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>

                        </div>
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