@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @if (count($errors))
                @include('cms.partials.errors')
            @endif

            @include('cms.site_sections.form', compact('form', 'sites', 'sections', 'templates'))

        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $(document).on('change', '#site_id', function () {
                var domain = $(':selected', this).text();

                $('#section_id').find('optgroup').show();
                $('#section_id').find('optgroup[label="' + domain + '"]').hide();
                return false;
            });
        });
    </script>
@endsection