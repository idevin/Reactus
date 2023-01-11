<ol class="breadcrumb" style="margin-top: 2em;">
	@foreach ($breadcrumbs as $item)
		@if (count($item) == 1)
			<li class="active">{{ $item[0] }}</li>
		@elseif(count($item) == 2)
			<li>{{ link_to_route($item[1], $item[0]) }}</li>
		@endif
	@endforeach
</ol>