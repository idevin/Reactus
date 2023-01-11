<div class="list-items @if(isset($view) && $view == 'grid') hidden @endif" data-view="list">
    <div class="js-articles-list" @if (isset($section)) data-section-id="{{ $section->id }}" @endif>
        @each(theme('article.list-view-item'), $articles, 'article')
    </div>
</div>
