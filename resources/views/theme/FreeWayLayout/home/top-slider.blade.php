@if(isset($slides) && count($slides) > 0)
    <div id="top-carousel-thumbs" class="slider-thumbs top-slider-thumbs jcarousel">
        <div class="jcarousel-list">
            @foreach($slides as $slide)
                <div class="carousel-item">
                    <div class="slider-thumb">
                        <img src="{{ $slide->image }}" alt=""/>

                        <div class="slider-thumb-text">
                            <p>{{ $slide->title }}</p>
                            <a href="{{ $slide->url }}" class="small">{{ $slide->domain }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
