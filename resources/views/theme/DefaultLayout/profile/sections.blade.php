@extends('StaticDefaultLayout')

@section('content')
    <section class="articles">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="row">
                <div class="col-md-6 col-lg-9">

                    @include(theme('partials.flash'))

                    @if(count($sections->items()) > 0)
                        <div class="view-section" @if(isset($section))data-section-id="{{$section->id}}@endif">

                            <div class="view-section-heading">
                                <h2 class="main-heading">МОИ РАЗДЕЛЫ</h2>

                                @include(theme('section.sort-search-panel'))
                            </div>

                            @include(theme('section.subsections'), compact('sections'))
                        </div>
                    @endif
                </div>

                {{-- sidebar --}}
                    <div class="sidebar sidebar-inner">
                        <div class="sidebar-block">
                            @include(theme('profile.profile-right-bar'))
                        </div>
                    </div>
            </div>
        </div>
    </section>

    @include(theme('home.more'))

@stop