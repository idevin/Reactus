<div class="col-sm-6 col-md-4 col-lg-3">
  <div class="view-section">
    <div class="view-section-heading clearfix">
      <div class="view-icons pull-right">
        <a href="#" class="view-icon" data-view-button="grid"><span class="icon icon-grid"></span></a>
        <a href="#" class="view-icon active" data-view-button="list"><span class="icon icon-list"></span></a>
      </div>

      <h4 class="main-heading">{{ $heading }}</h4>
    </div>

    <div class="list-items hidden" data-view="list">
      <div class="topic-list-item topic-carousel carousel">
        <div class="scrollable">
          <div class="bxslider topic-body">

            @each(theme('home.scrollable-block-item'), $list, 'article')

            <div class="topic-item-more">
              <button type="button" class="btn btn-primary btn-block" data-more data-url="{{ $data_url }}">Показать еще</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>