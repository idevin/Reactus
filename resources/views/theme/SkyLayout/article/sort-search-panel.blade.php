@include(theme('partials.sort-search-panel'), [
	'sort_url' => $sort_url,
	'search_url' => $search_url,
	'sort_options' => $sort_options,
	'data_type' => $data_type,
	'defaultDirection' => $sortOptions->filter_articles_sort_direction,
	'defaultSort' => $sortOptions->filter_articles_sort,
	'enabledSort' => $sortOptions->filter_articles,
	'defaultView' => ($sortOptions->filter_articles_view == 0 ? 'list' : 'grid')
])