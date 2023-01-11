@if($articles && !empty($articles->items()))
    <div class="view-section" data-section-id="{{$section->id}}">

        <div class="view-section-heading">

            <h2 class="main-heading">СТАТЬИ</h2>

            @if(count($section->articles) > 0)
                @include(theme('article.sort-search-panel'))
            @endif
        </div>


        <div class="articles-list-view">
            @include(theme('article.list-view'), ['section' => $section])
        </div>

        <div class="articles-grid-view">
            @include(theme('article.grid-view'), ['section' => $section])
        </div>

        <div class="js-articles-pagination">
            @include(theme('partials.pagination'), ['paginator' => $articles])
        </div>
    </div>
@endif