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


            {{ Form::model($form, ['url' => route($action, ['id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

            <input type="hidden" name="object" value="{{$object}}">
            <input type="hidden" name="objectId" value="{{$objectId}}">
            <input type="hidden" name="id" value="{{$moderationAnswer->id}}">

            <div>
                <h3>{{$article->title}}</h3>
                {!! $article->content !!}
            </div>

            <div class="form-group clearfix">
                {{ Form::label('content', 'Примечание', ['class' => 'col-sm-2 control-label required']) }}

                <div class="col-sm-10">
                    {{ Form::textarea('content', $moderationAnswer->content, ['class' => 'form-control', 'id' => 'content']) }}
                </div>
            </div>

            <div class="btn-toolbar" role="toolbar">
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>

            {{ Form::close() }}


        </div>
    </div>
@stop