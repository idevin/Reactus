<div class="topic-item">
  <a href="{{ route_to_article($item) }}" class="topic-item-title"><strong>{{ $item->title }}</strong></a>
  <p><small>{{ datetime_format($item->published_at) }}</small></p>
  <div class="item-params">
    <div class="item-param">
      <span class="icon icon-views"></span> <small>{{ counter_format($item->views_cnt) }}</small>
    </div>
    <div class="item-param">
      <span class="icon icon-like"></span> <small>{{ counter_format($item->likes_cnt) }}</small>
    </div>
    <div class="item-param">
      <span class="icon icon-comments"></span> <small>{{ counter_format($item->comments_cnt) }}</small>
    </div>
  </div>
</div>
