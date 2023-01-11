<div class="grid-items @if(isset($view) && $view == 'list') hidden @endif" data-view="grid">
    <div class="row">
        <div class="js-articles-grid" @if (isset($section)) data-section-id="{{ $section->id }}" @endif>

            @each(theme('article.grid-view-item'), $articles, 'article')
        </div>
    </div>
</div>
