<div class="carousel-item">
  <div class="slider-thumb">
    <img src="{{ $slide->image }}" alt=""/>
    <div class="slider-thumb-text">
      <p>{{ $slide->title }}</p>
      <a href="{{ $slide->url }}" class="small">{{ idnToUtf8($slide->domain) }}</a>
    </div>
  </div>
</div>