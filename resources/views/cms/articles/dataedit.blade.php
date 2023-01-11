@extends('cms.ui.dataedit')
@if (count($errors) > 0)
    @include('cms.partials.errors')
@endif
@section('scripts')

    <script>

        $(function () {
            $('#site').change(function () {

                var url = $(this).data('section-options-url');

                $.get(url,
                    {site_id: $(this).val()},
                    function (data) {
                        $("#div_section").html(data);
                    }
                )
            });
        })
    </script>
@stop