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
                                    <th>Домен</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($fields as $item)
                                    @if($item->user_id == $user->id)
                                        <tr data-toggle="collapse">

                                            <td>{{$item->id}}</td>
                                            <td>
                                                <?php $roles = $item->roles()->get(); ?>
                                                <?php if(count($roles) > 0): ?>

                                                @foreach($roles as  $index => $role)
                                                    {{$role->role->description}} &nbsp;
                                                    @endforeach
                                                    <?php else: ?>
                                                    &mdash;
                                                    <?php endif; ?>
                                            </td>
                                            <td>
                                                @if($item->site)
                                                    {{$item->site->domain}}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('site_users.edit', ['site_user' => $item->id], false) }}"
                                                   class="btn
                                                btn-default btn-sm"
                                                   onclick="window.location.href=$(this).attr('href');"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('site_users.destroy', ['site_user' => $item->id], false) }}"
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