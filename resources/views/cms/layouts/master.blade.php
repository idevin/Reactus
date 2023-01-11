<!DOCTYPE html>
<html lang="en">
<head>
    @include('cms.partials.head')
</head>

<body>
<div id="wrapper">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Навигация</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('cms.index')}}">CMS</a>
        </div>

        @include('cms.partials.navbar')
        @include('cms.partials.sidebar')
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>

@include('cms.partials.foot')

@yield('scripts')

</body>
</html>
