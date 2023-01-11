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

                @foreach($groupedFields as $groupedField => $user)

                    <div class="list-group-item" id="user{{$groupedField}}">
                        <div class="expander{{$user->id}}" data-target="#user{{$groupedField}}content"
                             data-toggle="collapse"
                             data-group-id="{{$user->id}}"
                             data-role="expander">
                            <ul class="list-inline">
                                <li style="float:right;" id="user{{$groupedField}}icon"><i class="fa fa-eye"
                                                                                           aria-hidden="true"></i></li>
                                <li>{{username($user)}}</li>
                            </ul>
                        </div>

                        <div class="collapse" id="user{{$groupedField}}content" data-group-id="{{$user->id}}"
                             aria-expanded="true">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Роль</th>
                                    <th>Раздел</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($fields as $item)
                                    @if($item->user_id == $user->id)
                                        <tr data-toggle="collapse">
                                            <td>{{$item->id}}</td>
                                            <td>
                                                @foreach($item->roles()->get() as $role)
                                                    @if($role->role)
                                                        {{$role->role->description}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($item->section)
                                                {{truncate_content($item->section->title, 100)}}
                                                @else
                                                &mdash;
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('section_users.edit', ['section_users' => $item->id]) }}"
                                                   class="btn
                                                btn-default btn-sm"
                                                   onclick="window.location.href=$(this).attr('href');"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('section_users.destroy', ['section_users' => $item->id], false) }}"
                                                   class="btn btn-danger btn-sm"
                                                   data-method="delete" data-confirm="Точно удалить ?"><i
                                                            class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-lg-12">
                        @if(count($fields) > 0)
                            @include('cms.partials.pagination')
                        @endif
                    </div>
                </div>

            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>

@section('scripts')
    <script>
        var groupId;

        $('.collapse').on('show.bs.collapse', function () {
            groupId = $(this).data('group-id');
            if (groupId) {
                $('#user' + groupId + 'icon').html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
            }
        });

        $('.collapse').on('hide.bs.collapse', function () {
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