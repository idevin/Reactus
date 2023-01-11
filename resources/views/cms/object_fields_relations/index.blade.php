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

            @if (count($fields->items()) > 0)

                @foreach($fields as $groupedField => $field)

                    @if(count($field->fieldGroups) > 0)
                        <div class="list-group-item" id="user{{$groupedField}}">
                            <div class="expander{{$field->id}}" data-target="#user{{$groupedField}}content"
                                 data-toggle="collapse"
                                 data-group-id="{{$field->id}}"
                                 data-role="expander">
                                <ul class="list-inline">
                                    <li style="float:right;" id="user{{$groupedField}}icon"><i class="fa fa-eye"
                                                                                               aria-hidden="true"></i>
                                    </li>
                                    <li>{{$field->name}}</li>
                                </ul>
                            </div>

                            <div class="collapse" id="user{{$groupedField}}content" data-group-id="{{$field->id}}"
                                 aria-expanded="true">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название группы</th>
                                        <th>Поля</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($field->fieldGroups as $item)
                                        <tr data-toggle="collapse">

                                            <td>{{$item->id}}</td>
                                            <td>
                                                {{$item->title}}
                                            </td>
                                            <td>
                                                @if(count($item->fields) > 0)
                                                @foreach($item->fields as $objectField)
                                                {{$objectField->name}}
                                                @endforeach
                                                @else
                                                &mdash;
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('object_fields_relations.destroy', ['object_fields_relation' => $item->id, 'catalog_id' => $groupedField], false) }}"
                                                   class="btn btn-danger btn-sm"
                                                   data-method="delete" data-confirm="Точно удалить ?"><i
                                                            class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif

        </div>
    </div>
@stop