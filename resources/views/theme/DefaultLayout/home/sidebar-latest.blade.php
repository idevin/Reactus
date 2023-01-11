@if(isset($latest) && count($latest) > 0)
    <div class="sidebar-block">
        <div class="topic-list-item popular">
            <div class="topic-title">
                <a href="#" class="topic-list-toggle pull-right">ЛУЧШЕЕ</a>

                @if($site)
                    <strong class="text-uppercase">{{ $site->domain }}</strong>
                @endif

            </div>
            <div class="topic-body">
                <div class="scrollable">

                    @each(theme('home.sidebar-scrollable-item'), $latest, 'item')

                    <div class="topic-item-more">
                        <a href="#" class="btn btn-primary btn-block" data-more>Показать еще</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
