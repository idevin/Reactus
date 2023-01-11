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

            @if (count($groupedFields) > 0)

                @foreach($groupedFields as $groupedField => $field)

                    <div class="list-group-item" id="user{{$groupedField}}">
                        <div class="expander{{$groupedField}}" data-target="#user{{$groupedField}}content"
                             data-toggle="collapse"
                             data-group-id="{{$groupedField}}"
                             data-role="expander">
                            <ul class="list-inline">
                                <li style="float:right;" id="user{{$groupedField}}icon"><i class="fa fa-eye"
                                                                                           aria-hidden="true"></i></li>
                                <li>{{$field['field_group']->title}}</li>
                            </ul>
                        </div>
                        @if(count($field['fields']) > 0)
                            <div class="collapse" id="user{{$groupedField}}content"
                                 data-group-id="{{$groupedField}}"
                                 aria-expanded="true">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя поля</th>
                                        <th>Тип</th>
                                        <th>№ по порядку</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($field['fields'] as $item)
                                        <tr data-toggle="collapse">
                                            <td>
                                                {{$item->id}}
                                            </td>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>
                                                {{\App\Models\NeoCatalogField::$fieldTypes[$item->field_type]['name']}}
                                            </td>
                                            <td>
                                                {{$item->sort_order}}
                                            </td>
                                            <td style="white-space: nowrap;">

                                                <a href="{{ route('object_fields.edit', ['object_field' => $item->id], false) }}"
                                                   class="btn btn-default"
                                                   onclick="window.location.href=$(this).attr('href');"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('object_fields.destroy', ['object_field' => $item->id], false) }}"
                                                   class="btn btn-danger btn-sm"
                                                   data-method="delete" data-confirm="Точно удалить ?"><i
                                                            class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach

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

@section('scripts')
    <script>
        let groupId;
        let collapse = $('.collapse');

        collapse.on('show.bs.collapse', function () {
            groupId = $(this).data('group-id');
            if (groupId) {
                $('#user' + groupId + 'icon').html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
            }
        });

        collapse.on('hide.bs.collapse', function () {
            groupId = $(this).data('group-id');
            if (groupId) {
                $('#user' + groupId + 'icon').html('<i class="fa fa-eye" aria-hidden="true"></i>');
            }
        });
    </script>
@endsection

<style>
    ul {
        padding-bottom: 10px;
        margin-bottom: -10px;
    }
</style>

@stop