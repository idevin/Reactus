<div class="communities-item clearfix">
  <div class="communities-item-image pull-left">
  @if ($community->image)
    <img src="{{ $community->imageUrl('70x70','community') }}" width="70" height="70" alt="" />
  @endif
  </div>
  <div class="communities-item-desc">
    <p class="communities-item-title"><strong>{{ $community->title }}</strong></p>
    <p class="communities-item-rating">{{ rating_format($community->rating) }}</p>
    <p class="communities-item-members"><span class="icon icon-communities"></span> {{ counter_format($community->members_cnt) }}</p>
  </div>
</div>