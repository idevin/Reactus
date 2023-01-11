<div class="list-items  @if(isset($view) && $view == 'grid') hidden @endif" data-view="list">
    <div class="js-sections-list" @if(isset($section))data-section-id="{{ $section->id }}@endif">
        @each(theme('section.list-view-item'), $sections, 'section')
    </div>
</div>