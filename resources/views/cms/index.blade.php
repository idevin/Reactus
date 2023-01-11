@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления</title>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Панель управления</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-bell fa-fw"></i> Статистика для <b>{{idnToUtf8($site->domain)}}</b>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fas fa-comment fa-fw"></i> Кол-во комментариев
                            <span class="pull-right text-muted small"><em>{{$commentsCount}}</em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fas fa-user fa-fw"></i> Пользователи
                            <span class="pull-right text-muted small"><em>&mdash;</em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fas fa-list fa-fw"></i> Разделы
                            <span class="pull-right text-muted small"><em>{{$sectionsCount}}</em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fas fa-list fa-fw"></i> Статьи
                            <span class="pull-right text-muted small"><em>{{$articlesCount}}</em>
                            </span>
                        </a>
                    </div>
                    <!-- /.list-group -->
                    {{--<a href="#" class="btn btn-default btn-block">View All Alerts</a>--}}
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>

@stop