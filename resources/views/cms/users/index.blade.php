@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            {!! $filter !!}

            @include('cms.partials.flash')

            @if (count($users) > 0)

                <table class="table table-hover">
                    <thead>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>Аватар</th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'username', 'name' => 'Ник'])
                    </th>
                    <th>ФИО</th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'email', 'name' => 'Email'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'phone', 'name' => 'Телефон'])
                    </th>
                    <th>Роли</th>
                    <th>Статистика</th>
                    <th><input type="checkbox" class="sowns"></th>
                    <th>Действия</th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><img src="{{ $item->imageUrl('70x70', 'avatar') }}"/></td>
                            <td>{{ $item->username }}</td>
                            <td>
                                {{ $item->first_name }} {{ $item->last_name }}
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ implode(', ', $item->roles->pluck('description')->toArray()) }}
                            <td>
                                <small>
                                    супер-админ:
                                    @if((int)$item->superadmin == 1)
                                        да
                                    @else
                                        нет
                                    @endif
                                </small>
                                <br>
                                <small>дата создания: {{ $item->created_at_formated }}
                                    @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'created_at', 'name' => ''])
                                </small>
                                <br>
                                <small>кол-во статей: {{count($item->articles)}}</small>
                                <br>
                                <small>активный:
                                    @if($item->active == 1)
                                        +
                                    @else
                                        -
                                    @endif
                                    @include('cms.partials.sort_field', ['route' => 'cms.users.index', 'alias' => 'active', 'name' => ''])
                                </small>
                                <br>
                                <small>домен:
                                    <a href="{{getSchema()}}{{$item->domain}}" target="_blank">{{idnToUtf8($item->domain)}}</a>
                                </small>
                                <br>
                                <small>баланс:
                                    {{$item->balance}}
                                </small>
                            </td>
                            <td>
                                <input type="checkbox" class="sown" name="articles[{{ $item->id }}]"
                                       value="{{ $item->id }}">
                            </td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route('cms.users.edit', ['user_id' => $item->id], false) }}"
                                   class="btn btn-default btn-sm"><i
                                            class="fas fa-pencil-alt"></i></a>

                                @if($item->locked != 1)
                                    <a href="{{ route('cms.users.destroy', ['user_id' => $item->id], false) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Вы уверены?"><i class="fa fa-times"></i></a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="row">

                    <div class="col-lg-6">
                        @include('cms.partials.pagination')
                    </div>

                    <div class="col-lg-3">
                        <div class="pull-right" style="padding:8px;">
                            <small>удалить:</small>
                            <a style="margin: 20px 0;"
                               href="{{ route('cms.users.mass_change', ['mass_delete' => 1]) }}"
                               class="btn btn-danger mass-delete btn-sm"
                               data-method="delete" data-confirm="Удалить пользователей?"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="pull-right" style="padding:8px;">
                            <small>Сменить домен:</small>
                            {{ Form::select('domain',['Выберите домен...'] + $domains->toArray(), null, ['class' => 'form-control', 'id' => 'domain_select']) }}
                        </div>
                    </div>
                </div>

            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>
@stop