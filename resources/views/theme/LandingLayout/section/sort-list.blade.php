@if(count($sections) > 0)
    <ul class="sections-list-view" id="sortable" style="padding-left: 0;">
        @include(theme('section.sort-list-view'))
    </ul>
@endif
