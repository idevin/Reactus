<!DOCTYPE html>
<html lang="en">

<head>
    @include('cms.partials.head')
</head>

<body>

    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>

    @include('cms.partials.foot')
</body>

</html>
