@if((isset($moreRecent) && count($moreRecent) > 0) || (isset($morePopular) && count($morePopular) > 0) || (isset($moreBest) && count($moreBest) > 0) || (isset($moreDiscussed) && count($moreDiscussed) > 0))
    <section class="more-on-topic">
        <div class="container">
            <h2 class="main-heading">ЕЩЕ ПО ТЕМЕ</h2>

            <div class="row">
                <div class="topic-list">

                    @include(theme('home.scrollable-block'), ['heading' => 'ПОСЛЕДНЕЕ', 'list' => $moreRecent, 'data_url' => 'more/recent'])
                    @include(theme('home.scrollable-block'), ['heading' => 'ЧИТАЕМОЕ', 'list' => $morePopular, 'data_url' => 'more/popular'])
                    @include(theme('home.scrollable-block'), ['heading' => 'ЛУЧШЕЕ', 'list' => $moreBest, 'data_url' => 'more/best'])
                    @include(theme('home.scrollable-block'), ['heading' => 'ОБСУЖДАЕМОЕ', 'list' => $moreDiscussed, 'data_url' => 'more/discussed'])

                </div>
            </div>
        </div>
    </section>
@endif
