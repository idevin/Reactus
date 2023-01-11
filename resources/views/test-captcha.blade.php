@extends(session('theme'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding: 50px;">
                {!!

                    Recaptcha::render([ 'lang' => 'ru' ])
                !!}

                <button class="btn btn-success" id="ajax-check">ajax submit</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#ajax-check', function () {
                console.log(grecaptcha.getResponse());
                $.ajax({
                    url: "/ajax/check-captcha",
                    type: "POST",
                    async: false,
                    data: {
                        "g-recaptcha-response": grecaptcha.getResponse()
                    },
                    success: function (data) {
                    }
                })
            });
        });
    </script>
@stop


