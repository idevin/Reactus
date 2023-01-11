@if($section->image)
@section('header')
    @set('bgImage', $section->imageUrl('1280x200', 'section'))

    <header class="main-header-podsite" style="
            background: #000000 url('{{$bgImage}}') no-repeat center;
            background-size: auto 100%;
            ">

        <div>
            <div class="hero">
                <div class="container">
                    <div class="col-xs-12">
                        <div class="row logo-container">
                            @include(theme('partials.logo'))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

@endsection
@endif

@extends(session('theme'))

@section('content')
    <section class="articles">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="article-heading">
                <div class="container">
                    <h1><strong>{{ $section->title }}</strong></h1>

                    <div id="collapse-heading" class="panel-collapse collapse in">
                        {!! $section->content !!}
                    </div>

                    <div class="collapse-toggle-wrapper">
                        <a role="button" data-toggle="collapse" class="collapse-toggle" href="#collapse-heading"
                           aria-expanded="true">
                            <span class="icon icon-toggle-section"></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12">

                    @include(theme('partials.flash'))

                    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em><span class="message"></span></em></div>

                    @if(count($sections) > 0)
                        <div class="view-section" data-section-id="{{$section->id}}">

                            <div class="view-section-heading">
                                <h2 class="main-heading">Сортировка разделов</h2>
                            </div>
                            @include(theme('section.sort-list'), compact('sections'))
                        </div>

                    @section('scripts')
                        <script>
                            $(function () {
                                var sortable = $("#sortable");

                                sortable.sortable({
                                    cursor: "move",
                                    cursorAt: {
                                        top: -370
                                    },
                                    stop: function () {

                                        var data = {};
                                        sortable.find('li').each(function (index, element) {
                                            data[index] = $(element).data('id');
                                        });

                                        $.ajax({
                                            url: '{{route('frontend.section.sort.update', ['id' => $section->id])}}',
                                            method: 'POST',
                                            data: data,
                                            beforeSend: function () {
                                            },
                                            success: function (data) {
                                                if (data.result == 'success') {
                                                    $('.alert.alert-success').show();
                                                    $('.alert.alert-success .message').html(data.data);
                                                }
                                            },
                                            complete: function () {
                                            }
                                        });
                                    }
                                });

//                                sortable.disableSelection();
                            });
                        </script>
                    @endsection
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include(theme('home.more'))

@stop