@extends(session('theme'))

@section('content')
    <section class="single-article">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="view-section no-m">
                        <div class="article-toggle">
                            <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-article" aria-expanded="true">
                                <span class="icon icon-toggle-section"></span>
                            </a>
                        </div>

                        <h1 class="page-heading">{{ $article->title }}</h1>

                        <div id="collapse-article" class="panel-collapse collapse in">
                            <div class="article-header">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="author-info pull-right text-right">
                                            <!--
                                             <div class="author-rewards">
                                                 <span class="icon icon-reward"></span>
                                                 <span class="icon icon-cup"></span>
                                                 <span class="icon icon-voice"></span>
                                                 <span class="icon icon-reward-black"></span>
                                             </div>
 -->
                                            <div class="author-status user-profile-status">
                                                <p>
                                                    {{$article->author->status}}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="navbar-user navbar-user-green pull-left">
                                            <div class="navbar-user-av">
                                                <div class="navbar-user-av-block">

                                                    <img src="{{$article->author->imageUrl('70x70', 'avatar')}}" width="70" height="70" alt=""/>
                                                    <span class="navbar-user-lvl">{{(int)$article->author->rating}}</span>
                                                </div>
                                            </div>
                                            <div class="navbar-user-info">{{ username($article->author) }}
                                                <p class="navbar-user-name dark lg"></p>

                                                <p class="navbar-user-role">Писатель 20 lvl</p>

                                                @if($user && ($user->id != $article->author_id))
                                                        <!--
                                                    <div class="navbar-user-actions">
                                                        <a href="#" class="navbar-user-action"><span class="icon icon-chat"></span></a>
                                                        <a href="#" class="navbar-user-action"><span class="icon icon-gift"></span></a>
                                                        <a href="#" class="navbar-user-action"><span
                                                                    class="icon icon-complaint-small"></span></a>
                                                        <a href="#" class="navbar-user-action"><span class="icon icon-plus-circle"></span></a>
                                                    </div>
                                                    -->
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="article-subheader row">
                                    <div class="col-xs-12">
                                        <div class="article-date pull-right">
                                            <span class="icon icon-date"></span> {{ datetime_format($article->published_at) }}
                                        </div>

                                        @if($article->status != \App\Models\Article::STATUS_ON_MODERATION)
                                            <div class="article-actions">
                                                {{--<a href="#">Просмотр</a>--}}

                                                @if(Auth::user() && Auth::user()->can('article.edit') && Auth::user()->id == $article->author->id)
                                                    <a href="{{ route('section.article.view-edit-form', ['section' => $article->section ? $article->section->path : null, 'article_slider' => $article->hash_id]) }}">Изменить</a>

                                                    {{--<a href="{{route('article.history')}}">История</a>--}}
                                                @endif
                                                {{--<a href="#">Подшивка</a>--}}
                                                {{--<a href="#">Еще</a>--}}
                                            </div>
                                        @else
                                            <h3>Статья на модерации</h3>

                                            @if($moderationAnswer && strtotime($moderationAnswer->confirmed_at) < 0)
                                                <div class="alert alert-danger">
                                                    {!! $moderationAnswer->content !!}
                                                </div>
                                            @endif

                                            @if(strtotime($moderationAnswer->confirmed_at) < 0 &&
                                             ($article->author_id == Auth::user()->id))
                                                <div align="right">
                                                    <a href="{{route('moderation_answer.confirm', ['id' => $moderationAnswer->id])}}">
                                                        подтвердить проверку
                                                    </a>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="content-body">
                                <article class="article-body">
                                    <div class="article-main-image">
                                        @if ($article->image)
                                            <img src="{{ $article->imageUrl('880x480', 'article_slider') }}"/>
                                        @endif
                                    </div>

                                    <div class="article-quote-body">
                                        {!! $article->content !!}
                                    </div>

                                    <div class="article-info clearfix">
                                        @if($user && ($user->id != $article->author_id))
                                            <p><strong>Оцените статью</strong></p>

                                            <div class="pull-left">
                                                <div class="article-info-rating">
                                                    <div class="rating-panel rating-lg article" data-id="{{$article->id}}">
                                                        <div class="rating-panel-current  js-open-rating">
                                                            <p><strong>+</strong></p>

                                                            <p class="rating-panel-current-value">{{ rating_format($article->rating) }}</p>

                                                            <p><strong>-</strong></p>
                                                        </div>

                                                        <div class="rating-panel-control js-rating article" data-id="{{$article->id}}">
                                                            <div class="rating-panel-values  js-circle-rating article">
                                                                <div class="rating-panel-value js-close-rating"><span
                                                                            class="icon icon-close"></span>
                                                                </div>
                                                                <div class="rating-panel-value">1</div>
                                                                <div class="rating-panel-value">2</div>
                                                                <div class="rating-panel-value">3</div>
                                                                <div class="rating-panel-value">4</div>
                                                                <div class="rating-panel-value">5</div>
                                                                <div class="rating-panel-value">6</div>
                                                                <div class="rating-panel-value">7</div>
                                                                <div class="rating-panel-value">8</div>
                                                                <div class="rating-panel-value">9</div>
                                                                <div class="rating-panel-value">10</div>
                                                            </div>

                                                            <div class="rating-panel-back js-close-rating"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($article->status != \App\Models\Article::STATUS_ON_MODERATION)
                                            <div class="article-params">
                                                <p class="text-muted">
                                                <span class="article-params-item"><span
                                                            class="icon icon-views"></span> {{ counter_format($article->views_cnt) }}</span>
                                                <span class="article-params-item"><span
                                                            class="icon icon-comments"></span> {{ counter_format($article->comments_cnt) }}</span>
                                                </p>

                                                @if (count($article->tags) > 0)
                                                    <p class="text-muted">
                                                        <span class="icon icon-tags"></span>

                                                        @foreach ($article->tags as $tag)
                                                            <a href="#" class="text-muted">{{ $tag->name }}</a>
                                                        @endforeach

                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                </article>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="sidebar sidebar-inner">

                        <div class="sidebar-block">
                            @include(theme('article.sidebar-sections'))
                        </div>

                        <div class="sidebar-block">
                            @include(theme('article.sidebar-discussed'))
                            @include(theme('article.sidebar-popular'))
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="modal modal-middle modal-complaint no-border fade" id="delete-comment" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="icon icon-error"></span>
                    </button>

                    <div class="modal-header">
                        <div class="modal-icon">
                            <span class="icon icon-complaint-big"></span>
                        </div>

                        <p><strong>Удаление коментария</strong></p>
                    </div>

                    <div class="modal-body">
                        <p>Удалить комментарий?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-lg delete-comment-button" data-dismiss="modal">ОК</button>
                        <button type="button" class="btn btn-dark btn-lg" data-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
