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
                    @include('cms.partials.sort_field', ['route' => 'comments.index', 'alias' => 'id', 'name' => 'ID'])
                </th>
                <td>Контент</td>
				<th>Сайт</th>
                <th>Автор</th>
                <th>Действия</th>
			</thead>
			<tbody class="sortable" data-entityname="footer-menu">
			@foreach ($fields as $item)
			<tr data-itemId="{{ $item->id }}">
				<td>{{ $item->id }}</td>
                <td><small>{!! truncate_content(html_entity_decode($item->content), 100, true, true) !!}</small></td>
				<td>{{ idnToUtf8($item->site->domain) }}</td>
                <td>{{ username($item->author) }}</td>
                <td>
                    <a href="{{ route('comments.edit', ['comment' => $item->id], false) }}" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a>
                    <a href="{{ route('comments.destroy', ['comment' => $item->id], false) }}" class="btn btn-danger btn-sm" data-method="delete" data-confirm="Вы уверены?"><i class="fa fa-times"></i></a>
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
		@else
			<p class="alert alert-warning">Записей не найдено</p>
		@endif

    </div>
</div>
@stop