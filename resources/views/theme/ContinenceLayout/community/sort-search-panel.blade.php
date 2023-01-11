@include(theme('partials.sort-search-panel'), [
	'sort_url' => $sort_url,
	'search_url' => $search_url,
	'sort_options' => $sort_options,
	'data_type' => $data_type,
	'defaultDirection' => $site->filter_sections_sort_direction,
	'defaultSort' => $site->filter_sections_sort,
	'enabledSort' => $site->filter_sections,
	'defaultView' => ($site->filter_sections_view == 0 ? 'list' : 'grid')
])