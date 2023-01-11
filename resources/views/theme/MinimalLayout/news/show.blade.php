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

                        <h1 class="page-heading">{{ $news->title }}</h1>

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
                                                    {{$news->user->status}}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="navbar-user navbar-user-green pull-left">
                                            <div class="navbar-user-av">
                                                <div class="navbar-user-av-block">
                                                    <img src="{{$news->user->imageUrl('70x70', 'avatar')}}" width="70" height="70" alt=""/>
                                                    <span class="navbar-user-lvl">{{(int)$news->user->rating}}</span>
                                                </div>
                                            </div>
                                            <div class="navbar-user-info">{{ $news->user->username }}
                                                <p class="navbar-user-name dark lg"></p>

                                                <p class="navbar-user-role">Писатель 20 lvl</p>

                                                @if($news->user && ($user->id != $news->user_id))
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
                                            <span class="icon icon-date"></span> {{ getFormatedDate($news->created_at) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content-body">
                                <article class="article-body">
                                    <div class="article-main-image">
                                        @if ($news->image)
                                            <img src="{{ $news->imageUrl('880x650', 'news') }}"/>
                                        @endif
                                    </div>
                                    <div class="article-quote-body">
                                        {!! $news->content !!}
                                    </div>
                                </article>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="sidebar sidebar-inner">

                        <div class="sidebar-block">
                            @include(theme('news.sidebar-sections'))
                        </div>

                        <div class="sidebar-block">
                            {{--@include(theme('news.sidebar-discussed'))--}}
                            {{--@include(theme('news.sidebar-popular'))--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
