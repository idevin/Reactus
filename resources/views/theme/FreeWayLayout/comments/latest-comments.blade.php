@if (count($latestComments) > 0)
    <section class="latest-comments">
        <div class="view-section">
            <div class="view-section-heading clearfix">
                <div class="view-icons pull-right">
                    <a href="#" class="view-icon" data-view-button="grid"><span class="icon icon-grid"></span></a>
                    <a href="#" class="view-icon active" data-view-button="list"><span class="icon icon-list"></span></a>
                </div>

                <h2 class="main-heading">ПОСЛЕДНИЕ КОММЕНТАРИИ</h2>
            </div>

            <div class="list-items hidden" data-view="list">
                <div class="comments-carousel carousel">
                    <div class="jcarousel vertical">
                        <ul class="jcarousel-list list-unstyled">
                            @each(theme('comments.latest-comments-list-view'), $latestComments, 'article')
                        </ul>
                    </div>

                    <div class="owl-controls vertical">
                        <div class="owl-buttons">
                            <div class="owl-prev jcarousel-prev">prev</div>
                            <div class="owl-next jcarousel-next">next</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid-items hidden" data-view="grid">
                <div class="row">
                    @each(theme('comments.latest-comments-grid-view'), $latestComments, 'article')
                </div>
            </div>

        </div>
    </section>
@endif
