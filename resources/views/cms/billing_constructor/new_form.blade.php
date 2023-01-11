@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @if (count($errors))
                @include('cms.partials.errors')
            @endif

            @include('cms.billing_constructor.form', compact('form'))

        </div>
    </div>
@stop