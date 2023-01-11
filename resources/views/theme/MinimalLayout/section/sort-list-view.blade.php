{{--<div class="js-sections-list" @if(isset($section))data-section-id="{{ $section->id }}@endif">--}}
@each(theme('section.sort-list-view-item'), $sections, 'section')
{{--</div>--}}
