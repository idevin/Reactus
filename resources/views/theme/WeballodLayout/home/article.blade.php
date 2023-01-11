@if(!empty($articles))
    @foreach($articles as $article)
        <div class="block-main text-center">
            <div class="container">
                <div class="main-title">
                    <h2>
                        <strong>{{mb_strtoupper($article->title)}}</strong>
                    </h2>
                </div>

                @if(!empty($article->image))
                    <div class="block-main-img pull-left">
                        <img src="{{ $article->imageUrl('300x170', 'article') }}"/>
                    </div>
                @endif

                <div class="block-main-text">
                    {!! truncate_content($article->content, 500) !!}
                </div>

                <a class="btn btn-primary btn-lg btn-xlg" href="{{route_to_article($article)}}">Подробнее</a>
            </div>
        </div>
    @endforeach
@endif
