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
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>URL</th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'title', 'name' => 'Заголовок'])
                    </th>
                    <th>Автор</th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'rating', 'name' => 'Рейтинг'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'views_cnt', 'name' => 'Просмотры'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'comments_cnt', 'name' => 'Комментарии'])
                    </th>
                    <th style="white-space: nowrap;">
                        @include('cms.partials.sort_field', ['route' => 'articles.index', 'alias' => 'created_at', 'name' => 'Дата публикации'])
                    </th>
                    <th><input type="checkbox" class="sowns"></th>
                    <th>Действия</th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route_to_article($item) }}"
                                   target="_blank">{{ substr(route_to_article($item), 0, 30) }}...</a>
                                <br>

                                <small>

                                    @if($item->section)
                                        @if($item->section->parent_id != null)
                                            <a style="color: #666666;" href="{{ route_to_section($item->section) }}"
                                               target="_blank">{{ mb_substr($item->section->title, 0, 30) }}
                                                @if(mb_strlen($item->section->title) > 30)
                                                    ...
                                                @endif
                                            </a>
                                        @else
                                            @if($item->section && $item->section->site)
                                                <a style="color: #666666;"
                                                   href="{{env('HTTP_X_SCHEME')}}://{{$item->section->site->domain}}/sections"
                                                   target="_blank">Разделы</a>
                                            @endif
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>
                                {{$item->title}}
                            </td>
                            <td style="white-space: nowrap;">
                                {{username($item->author)}}
                            </td>
                            <td>
                                {{$item->rating}}
                            </td>
                            <td>
                                {{$item->views_cnt}}
                            </td>
                            <td>
                                {{$item->comments_cnt}}
                            </td>
                            <td style="white-space: nowrap;">
                                {{getFormatedDate($item->created_at)}}
                            </td>
                            <td>
                                <input type="checkbox" class="sown" name="articles[{{ $item->id }}]"
                                       value="{{ $item->id }}">
                            </td>
                            <td style="white-space: nowrap;">
                                @if(!$item->trashed())

                                    <a href="{{ route('articles.edit', ['article' => $item->id], false) }}"
                                       class="btn btn-default"><i
                                                class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('articles.destroy', ['article' => $item->id], false) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить ?"><i
                                                class="fa fa-times"></i></a>
                                @else
                                    <a href="{{ route('articles.undelete', ['articles' => $item->id], false) }}"
                                       class="btn btn-default"><i
                                                class="fa fa-check"></i></a>

                                    <a href="{{ route('articles.destroyForever', ['articles' => $item->id], false) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Удалить навсегда статью?"><i
                                                class="fa fa-window-close"></i></a>
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

                <div class="row pull-right">
                    <div style="margin-top: -5px; margin-left: 15px;">
                        <small>массовые действия:</small>
                    </div>
                    <div class="col-lg-2">
                        <a style=""
                           href="{{ route('articles.massDelete', ['mass_delete' => 1], false) }}"
                           class="btn btn-danger mass-delete btn-sm"
                           data-method="post" data-back="{{route('articles.index')}}"
                           data-confirm="Удалить выбранные статьи?">Удалить</a>
                    </div>

                    <div class="col-lg-3">
                        <a style=""
                           href="{{ route('articles.restore') }}"
                           data-url="{{ route('articles.restore') }}"
                           class="btn btn-danger btn-sm restore"
                           data-back="{{route('articles.index')}}">Восстановить</a>
                    </div>

                    <div class="col-lg-6">
                        <select name="author_id" id="author_id" class="btn btn-danger change-author"
                                data-url="{{ route('articles.massUpdateAuthor', ['mass-update-author' => 1]) }}">
                            <option value="">Сменить автора...</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{username($user)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).on('change', '#author_id', function () {
            var ids = [];

            $('.sown').each(function (i, value) {
                if ($(value).prop('checked') === true) {
                    ids.push($(value).val());
                }
            });

            if (ids.length > 0) {
                $.post($(this).data('url') + '&o=' + ids + '&author_id=' + $(this).val(), null, function () {
                    window.location.href = '{{route('articles.index')}}';
                });

            }

            return false;
        });
    </script>

    <script>
        $(document).on('click', '.restore', function () {
            var ids = [];

            $('.sown').each(function (i, value) {
                if ($(value).prop('checked') === true) {
                    ids.push($(value).val());
                }
            });

            if (ids.length > 0) {
                $.post($(this).data('url') + '?o=' + ids, null, function () {
                    window.location.href = '{{route('articles.index')}}';
                });

            }

            return false;
        });
    </script>
@endsection