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
                    <th>Шаблон</th>
                    <th>Название</th>
                    <th>Строки</th>
                    <th>Действия</th>
                    </thead>

                    <tbody class="sortable" data-entityname="footer-menu">
                    @foreach ($fields as $item)
                        <tr data-itemId="{{ $item->id }}">
                            <td>{{ $item->id }}</td>
                            <td>
                                {{$item->template->name}} ({{$item->template->alias}})
                            </td>
                            <td>{{$item->name}}</td>
                            <td>
                                @foreach($item->strokes as $sortOrder => $stroke)
                                    <div class="col-sm-12" style="border: 1px solid gray; margin-bottom:10px;">
                                        <b>{{$positions[$stroke->position]}}</b>
                                        @foreach($stroke->modules as $module)
                                            <div class="col-sm-12">
                                                <div class="col-sm-3">
                                                    № {{$module->sort_order}}
                                                </div>
                                                <div class="col-sm-9">
                                                    {{$module->module->name}}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                @endforeach
                            </td>

                            <td>
                                <a href="{{ route('template_prototypes.edit', ['template_prototype' => $item->id], false) }}"
                                   class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('template_prototypes.destroy', ['template_prototype' => $item->id], false) }}"
                                   class="btn btn-danger btn-sm" data-method="delete" data-confirm="Вы уверены?"><i
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
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif

        </div>
    </div>
@stop
