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
                    <th>Сайт</th>
                    <th>Поля</th>
                    <th>Для всех сайтов?</th>
                    <th>Действия</th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fieldsArray as $item)
                        @if(isset($item['site']))
                            <tr>
                                <td>{{ $item['site']->domain }}</td>
                                <td>
                                    @foreach($item as $group)
                                        @if(is_array($group))
                                            @if(isset($group['group']))
                                                <b>{{$group['group']->name}}: </b>
                                                @foreach($group['fields'] as $field)
                                                    @if($field->field)
                                                        {{$field->field->name}};
                                                    @endif
                                                @endforeach
                                                <br>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td>

                                </td>
                                <td>
                                    <a href="{{ route('feedback.edit', ['feedback' => $item['site']->id], false) }}" class="btn btn-default"><i
                                                class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('feedback.destroy', ['feedback' => $item['site']->id], false) }}" class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить?"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif
        </div>
    </div>
@stop