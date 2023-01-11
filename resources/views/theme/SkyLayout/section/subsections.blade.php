@if(!empty($sections->items()))
    <div class="sections-list-view">
        @include(theme('section.list-view'))
    </div>

    <div class="sections-grid-view">
        @include(theme('section.grid-view'))
    </div>

    <div class="js-sections-pagination">
        @include(theme('partials.pagination'), ['paginator' => $sections])
    </div>
@endif
