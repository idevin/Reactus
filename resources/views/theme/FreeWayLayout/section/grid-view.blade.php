<div class="grid-items  @if(isset($view) && $view == 'list') hidden @endif" data-view="grid">
    <div class="row">
        <div class="js-sections-grid" @if(isset($section))data-section-id="{{ $section->id }}@endif>
            @each(theme('section.grid-view-item'), $sections, 'section')
        </div>
    </div>
</div>