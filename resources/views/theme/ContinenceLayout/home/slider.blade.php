@if(isset($slider) && count($slider) > 0)
    <div class="main-slider">
        <div class="container">
            <div class="carousel main-carousel">
                <div id="main-carousel">
                    @foreach ($slider as $slide)
                        <div class="carousel-item">
                            <div class="main-slider-image">
                                <img src="{{ $slide->image_url }}" alt=""/>
                            </div>
                            <div class="main-slider-content">
                                @if (!$slide->isCustom())
                                    <div class="navbar-user">
                                        <div class="navbar-user-av">
                                            <div class="navbar-user-av-block">
                                                <img src="{{ $slide->article->author->imageUrl('70x70', 'avatar') }}" width="40" height="40" alt=""/>
                                            </div>
                                        </div>
                                        <div class="navbar-user-info">
                                            <p class="navbar-user-name">{{ $slide->article->author->username }}</p>

                                            <p class="navbar-user-role">Писатель 20 lvl</p>
                                        </div>
                                    </div>
                                @endif
                                <p class="h3"><strong>{{ $slide->title }}</strong></p>
                                {{-- <p class="main-slider-text">Эта заметка стала моей первой попыткой</p> --}}
                                <a href="{{ $slide->url }}" class="btn btn-bordered">Подробнее</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif