@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')

    <div class="row">
        <h1 class="page-header">{{ $title }}</h1>

        <div class="col-lg-12">
            @include('cms.partials.breadcrumbs', ['active' => $title])
            @include('cms.partials.flash')
        </div>
    </div>

    <div class="row">
        @include('cms.pool.articles')
        @include('cms.pool.comments')
    </div>

    <div class="row">
        @include('cms.pool.complains')
        @include('cms.pool.sections')
    </div>

@stop