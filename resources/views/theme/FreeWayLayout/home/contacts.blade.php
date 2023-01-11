@if(Session::get('site')->user)
    <div class="block-main">
        <div class="container">
            <div class="main-title text-center">
                <h1><strong>КОНТАКТЫ</strong></h1>
            </div>

            <div class="main-contacts">
                <div class="row">

                    @if(!empty(Session::get('site')->user->phone))
                        <div class="col-md-3">
                            <p><strong>Телефон</strong></p>
                            <span>{{Session::get('site')->user->phone}}</span>
                        </div>
                    @endif

                    @if(!empty(Session::get('site')->user->email))

                        <div class="col-md-3">
                            <p><strong>E-mail:</strong></p>
                            <a href="#">{{Session::get('site')->user->email}}</a>
                        </div>
                    @endif

                    @if(!empty(Session::get('site')->address))
                        <div class="col-md-3">
                            <p><strong>Адрес</strong></p>
                        <span>
                            {{Session::get('site')->address}}
                        </span>
                        </div>
                    @endif

                    @if(!empty(Session::get('site')->work_hours))
                        <div class="col-md-3">
                            <p><strong>Время работы</strong></p>
                            <span> {{Session::get('site')->work_hours}}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($settings && !empty($settings->coords))
                <div class="main-contacts-info">

                    <div class="container-full">
                        <div class="main-contacts-map">
                            <div id="location-map" class="location-map">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endif
