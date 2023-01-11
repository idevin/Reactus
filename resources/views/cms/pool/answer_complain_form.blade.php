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


            <table class="table table-hover">
                <thead>
                <th>ID</th>
                <th>Обьект</th>
                <th>Жалоба на</th>
                <th>Жалоба от</th>
                <th>Опция</th>
                <th>Текст</th>
                </thead>
                <tbody class="sortable" data-entityname="slider">
                <tr>
                    <td>{{ $complain->id }}</td>
                    <td>
                        @if($complain->object())
                            {!! html_entity_decode($complain->object()->getContentArray()['data']) !!}
                        @endif
                    </td>
                    <td>
                        {{username($complain->on_user)}}
                    </td>
                    <td>
                        {{username($complain->user)}}
                    </td>
                    <td>
                        @if($complain->complain_option->title)
                            {!! $complain->complain_option->title !!}
                        @endif
                    </td>
                    <td>
                        {{$complain->content}}
                    </td>
                </tr>
                </tbody>
            </table>

            {{ Form::model($form, ['url' => route($action, ['id' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

            <input type="hidden" name="id" value="{{$complain->id}}">

            <div class="form-group clearfix">
                {{ Form::label('answer', 'Ответ', ['class' => 'col-sm-2 control-label required']) }}

                <div class="col-sm-10">
                    {{ Form::textarea('answer', $complain->answer, ['class' => 'form-control', 'id' => 'content']) }}
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