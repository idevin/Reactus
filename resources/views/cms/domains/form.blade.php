{{ Form::model($form, ['url' => route($action, ['domains' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}


@if(!$form->id)
    <div class="form-group clearfix">
        {{ Form::label('name', 'Имя домена', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
        </div>
    </div>
@else
    <div class="form-group clearfix">
        {{ Form::label('name', 'Имя домена', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{idnToUtf8($form->name)}}
            {{ Form::hidden('name', $form->id, ['class' => 'form-control', 'id' => 'name']) }}
        </div>
    </div>
@endif


<div class="form-group clearfix">
    {{ Form::label('domain_type', 'Тип', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('domain_type', $domainTypes, null, array('id' => 'domain_type', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('language', 'Язык', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('language_id', [null => 'Выберите язык...'] + $language, null, array('id' => 'language', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('thematic', 'Тематика', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('domain_thematic_id', [null => 'Выберите тематику домена...'] + $thematic, $form->domain_thematic_id, array('id' => 'domain_thematic_id', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('hide_from_registration', 'Скрыть для регистрации?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('hide_from_registration', 1, $form->hide_from_registration == 1,
        ['id' => 'hide_from_registration']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('ssl', 'SSL?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('ssl', 1, $form->ssl == 1,
        ['id' => 'ssl']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('active', 'Активный домен?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('active', 1, $form->active == 1,
        ['id' => 'active']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('is_customer_domain', 'Домен владельца?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('is_customer_domain', 1, $form->is_customer_domain == 1,
        ['id' => 'is_customer_domain']) }}
    </div>
</div>

<div class="form-group clearfix user-form"
     @if( $form->is_customer_domain == 1)
     style="display: block;"
     @else
     style="display: none;"
        @endif
>
    {{ Form::label('user_id', 'Пользователь', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('user_id', $users, $form->user_id, ['class' => 'form-control', 'id' => 'user_id']) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{Form::hidden('environment', (env('DEVELOPMENT') == true ? 0 : 1))}}

{{ Form::close() }}

@section('scripts')
    <script>
        $(function () {
            $("#is_customer_domain").click(function (e) {
                if ($(this).prop('checked') === true) {
                    $(".user-form").show();
                } else {
                    $(".user-form").hide();
                }
            });
        });
    </script>
@endsection