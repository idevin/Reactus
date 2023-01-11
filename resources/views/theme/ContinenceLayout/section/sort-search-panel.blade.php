@include(theme('partials.sort-search-panel'), [
	'sort_url' => $sort_url,
	'search_url' => $search_url,
	'sort_options' => $sort_options,
	'data_type' => $data_type,
	'defaultDirection' => \App\Models\Section::$sortOptionsDefault['order'],
	'defaultSort' => \App\Models\Section::$sortOptionsDefault['field'],
	'enabledSort' => 1,
	'defaultView' => (\App\Models\Section::$sortOptionsDefault['view'] == 0 ? 'list' : 'grid')
])