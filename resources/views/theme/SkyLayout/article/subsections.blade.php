<div class="view-section">
    <div class="view-section-heading clearfix">
        <div class="view-icons pull-right">
            <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-1" aria-expanded="true">
                <span class="icon icon-toggle-section"></span>
            </a>
        </div>

        <h2 class="main-heading">РАЗДЕЛЫ</h2>

        @include(theme('includes.section.sort-search-panel'))
    </div>

    <div id="collapse-1" class="panel-collapse collapse in">

        @include(theme('partials.section.list-view'))
        @include(theme('partials.section.grid-view'))

        <div class="js-sections-pagination">
            <div class="pagination clearfix  js-pagination light-theme simple-pagination"></div>
        </div>
    </div>
</div>