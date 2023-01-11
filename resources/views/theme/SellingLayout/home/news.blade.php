@if(count($news) > 0)
    <section class="best">
        <div class="container">
            <div class="main-title text-center">
                <h2><strong>НОВОСТИ</strong></h2>
            </div>

            <div class="carousel best-carousel">
                <div id="best-carousel" class="list-unstyled">
                    @foreach($news as $newsItem)
                        <div class="carousel-item" data-range="day">
                            <div class="grid-item">
                                <a href="{{routeToNews($newsItem)}}" class="grid-item-image">

                                    @if(!empty($newsItem->thumbs))
                                        <img src="{{$newsItem->thumbs['thumb280x157']}}" width="280" height="157" alt=""/>
                                    @endif

                                    {{--<span class="grid-item-category">valve club</span>--}}
                                    <span class="grid-item-rating rating rating-white">{{$newsItem->rating}}</span>
                                </a>

                                <div class="grid-item-desc">
                                    <div class="navbar-user navbar-user-white">
                                        <div class="navbar-user-av">
                                            <div class="navbar-user-av-block">
                                                @if ($newsItem->user->avatar)
                                                    <img src="{{$newsItem->user->imageUrl('70x70', 'avatar') }}"
                                                         width="70"
                                                         height="70" alt=""/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="navbar-user-info">
                                            <p class="navbar-user-name">{{username($newsItem->user)}}</p>

                                            <p class="navbar-user-role">Писатель 29 lvl</p>
                                        </div>
                                    </div>

                                    <p class="grid-item-date">
                                        <small>
                                            {{--11 марта в 21:05--}}
                                            {{getFormatedDate($newsItem->created_at, 'ru', 'j F в H:i')}}
                                        </small>
                                    </p>

                                    <a href="{{routeToNews($newsItem)}}" class="grid-item-title">
                                        <strong>{{$newsItem->title}}</strong>
                                    </a>

                                    <!--
                                    <div class="item-params">
                                        <div class="item-param">
                                            <span class="icon icon-views"></span>
                                            <small>1990</small>
                                        </div>
                                        <div class="item-param">
                                            <span class="icon icon-like"></span>
                                            <small>90</small>
                                        </div>
                                        <div class="item-param">
                                            <span class="icon icon-comments"></span>
                                            <small>199</small>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif