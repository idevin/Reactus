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
                    <th>Название шаблона</th>
                    <th>Активный перенос?</th>
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
                                @if($item->section)
                                    {{$item->section->title}} ({{$item->section->site->domain}})
                                @endif
                            </td>
                            <td>
                                {{$item->template->name}}
                            </td>
                            <td>
                                @if($item->active == 1)
                                    Да
                                @else
                                    Нет
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('site_sections.edit', ['site_section' => $item->id], false) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('site_sections.destroy', ['site_section' => $item->id], false) }}"
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