@extends(session('theme'))

@section('content')
    <div class="moderate">
        <div class="container">

            @include(theme('includes.breadcrumbs'))

            <div class="row">
                @include(theme('moderate.sidebar'))
            </div>
        </div>
    </div>
@endsection