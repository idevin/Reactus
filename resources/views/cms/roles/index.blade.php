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
                    <th style="white-space: nowrap;">
                        @include('cms.partials.sort_field', ['route' => 'roles.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th style="white-space: nowrap;">
                        @include('cms.partials.sort_field', ['route' => 'roles.index', 'alias' => 'name', 'name' => 'Название'])
                    </th>
                    <th style="white-space: nowrap;">
                        @include('cms.partials.sort_field', ['route' => 'roles.index', 'alias' => 'description', 'name' => 'Описание'])
                    </th>
                    <th>Права</th>
                    <th>Статистика</th>
                    <th>Действия</th>
                    </thead>

                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{$item->description}}
                            </td>
                            <td>
                                <div class="more">
                                    @foreach($item->permissions()->get()->toArray()  as $permission)
                                        {{$permission['description']}} /
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <small>
                                    Кол-во пользователей: {{count($item->users()->get())}}
                                </small>
                                <br>
                                <small>
                                    Выдается при регистрации:
                                    @if($item->for_registered == 1)
                                        +
                                    @else
                                        -
                                    @endif
                                </small>
                                <br>
                                <small>
                                   Для анонимов:
                                    @if($item->is_anon == 1)
                                        +
                                    @else
                                        -
                                    @endif
                                </small>
                            </td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route('roles.edit', ['role' => $item->id], false) }}" class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>
                                @if($item->is_default != 1)
                                    <a href="{{ route('roles.destroy', ['role' => $item->id], false) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить ?"><i
                                                class="fa fa-times"></i></a>
                                @endif

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


@section("scripts")
    <script>
        $(document).ready(function () {
            var showChar = 650;
            var ellipsestext = "...";
            var moretext = "Подробнее";
            var lesstext = "Закрыть";

            $('.more').each(function () {
                var content = $(this).html();

                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a style="float:right;" href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function () {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });
    </script>

    <style>
        .morecontent span {
            display: none;
        }

        .morelink {
            display: block;
        }
    </style>

@endsection
@stop