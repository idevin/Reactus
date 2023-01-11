<div class="view-section">
    <div class="view-section-heading clearfix">
        <div class="view-icons pull-right">
            <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-3" aria-expanded="true">
                <span class="icon icon-toggle-section"></span>
            </a>

        </div>
        <h2 class="main-heading">СООБЩЕСТВА</h2>
        @include(theme('community.sort-search-panel'))
    </div>

    <div id="collapse-3" class="panel-collapse collapse in">

        @include(theme('community.list-view'))
        @include(theme('community.grid-view'))

        <div class="js-communities-pagination">
            <div class="pagination clearfix  js-pagination"></div>
        </div>

    </div>
</div>