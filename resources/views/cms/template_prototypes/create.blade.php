@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @if (count($errors) > 0)
                @include('cms.partials.errors')
            @endif

            @include('cms.partials.flash')

            @include('cms.footer_menu.form')

        </div>
    </div>

@stop
