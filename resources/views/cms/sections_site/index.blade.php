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
                    <th>Домен</th>
                    <th>Название раздела</th>
                    <th>Оставлять анонс?</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>
                                {{$item->id}}
                            </td>
                            <td>
                                {{$item->site->domain}}
                            </td>
                            <td>
                                @if(!$item->section)
                                    @if($item->toSection)
                                        {{$item->toSection->title}}
                                    @endif
                                @else
                                    &mdash;
                                @endif
                            </td>
                            <td>
                                @if($item->announce == 1)
                                    Да
                                @else
                                    Нет
                                @endif
                            </td>
                            <td>

                                <a href="{{ route('sections_site.destroy', ['sections_site' => $item->id], false) }}"
                                   class="btn btn-danger btn-sm"
                                   data-method="delete" data-confirm="Точно удалить ?"><i
                                            class="fa fa-times"></i></a>

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