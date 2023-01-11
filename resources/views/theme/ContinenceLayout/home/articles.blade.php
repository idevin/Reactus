@if (count($latestComments) > 0)
    <section class="latest-comments">

        <div class="container">
            <div class="view-section">
                <div class="view-section-heading clearfix">
                    <div class="view-icons pull-right">
                        <a href="#" class="view-icon" data-view-button="grid"><span class="icon icon-grid"></span></a>
                        <a href="#" class="view-icon active" data-view-button="list"><span class="icon icon-list"></span></a>
                    </div>

                    <h2 class="main-heading text-center">СТАТЬИ</h2>
                </div>

                <div class="list-items" data-view="list">
                    <div class="comments-carousel carousel">
                        <div class="jcarousel vertical" data-jcarousel="true">
                            <ul class="jcarousel-list list-unstyled" style="left: 0px; top: -110.4px;">

                                @if (count($latestComments) > 0)
                                    @each(theme('comments.latest-comments-list-view'), $latestComments, 'article')
                                @endif

                            </ul>
                        </div>

                        <div class="owl-controls vertical">
                            <div class="owl-buttons">
                                <div class="owl-prev jcarousel-prev" data-jcarouselcontrol="true">prev</div>
                                <div class="owl-next jcarousel-next" data-jcarouselcontrol="true">next</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid-items hidden" data-view="grid">
                    <div class="row">
                        @if (count($latestComments) > 0)
                            @each(theme('comments.latest-comments-grid-view'), $latestComments, 'article')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


