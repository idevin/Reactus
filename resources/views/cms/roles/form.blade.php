{{ Form::model($form, ['url' => route($action, ['roles' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

@if($form->is_default != 1)
    <div class="form-group clearfix">
        {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::text('name', $form->name, ['class' => 'form-control']) }}
        </div>
    </div>
@else
    {{ Form::hidden('name', $form->name) }}
@endif

@if($form->is_default != 1)
    <div class="form-group clearfix">
        {{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('description', $form->description, ['class' => 'form-control']) }}
        </div>
    </div>
@else
    <div class="form-group clearfix">
        {{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ $form->description }}
        </div>
    </div>
    {{ Form::hidden('description', $form->description) }}
@endif


@if($form->is_default != 1)
    <div class="form-group clearfix">
        {{ Form::label('for_registered', 'Выдается при регистрации?', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::checkbox('for_registered', isset($form->for_registered)) }}
        </div>
    </div>
@else
    <div class="form-group clearfix">
        {{ Form::label('for_registered', 'Выдается при регистрации?', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ $form->for_registered ? 'ДА' : 'НЕТ' }}
        </div>
    </div>
    {{ Form::hidden('for_registered', $form->for_registered) }}
@endif

@if($form->is_default != 1)
    <div class="form-group clearfix">
        {{ Form::label('is_anon', 'Для анонимов?', ['class' => 'col-sm-2 control-label required']) }}

        <div class="col-sm-10">
            {{ Form::checkbox('is_anon', isset($form->is_anon)) }}
        </div>
    </div>
@else
    <div class="form-group clearfix">
        {{ Form::label('is_anon', 'Для анонимов?', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ $form->is_anon ? 'ДА' : 'НЕТ' }}
        </div>
    </div>
    {{ Form::hidden('is_anon', $form->is_anon) }}
@endif

@if($form->is_default != 1)
    <div class="form-group clearfix">
        {{ Form::label('description', 'Права', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">

            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <label>
                        <input type="checkbox" name="selectAllOwn" class="sowns">
                    </label> - выбрать все
                </div>
                <div class="col-sm-4">
                    <label>
                        <input type="checkbox" name="selectAllOther" class="sothers">
                    </label> - выбрать все
                </div>
            </div>

            @foreach ($permissions as $permission)
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        {{$permission->description}}
                        <br>
                        <sup>{{$permission->name}}</sup>
                    </div>
                    <div class="col-sm-4">
                        {{ Form::checkbox('permissions[' . $permission->id . '][own]', 1, isset($formPermissions[$permission->id]) && ($formPermissions[$permission->id]['own'] == true), ['class' => 'sown']) }}
                        - свои
                    </div>
                    <div class="col-sm-4">
                        {{ Form::checkbox('permissions[' . $permission->id . '][other]', 1, isset($formPermissions[$permission->id]) && ($formPermissions[$permission->id]['other'] == true), ['class' => 'sother']) }}
                        - чужие
                    </div>

                </div>
            @endforeach

        </div>
    </div>
@else

    <div class="form-group clearfix">
        {{ Form::label('description', 'Права', ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">

            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <label>
                        Свои
                    </label>
                </div>
                <div class="col-sm-4">
                    <label>
                        Чужие
                    </label>
                </div>
            </div>

            @foreach ($permissions as $permission)
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        {{$permission->description}}
                        <br>
                        <sup>{{$permission->name}}</sup>
                    </div>
                    <div class="col-sm-4">

                        @if(isset($formPermissions[$permission->id]) && ($formPermissions[$permission->id]['own'] == true))
                            ДА
                        @else
                            НЕТ
                        @endif
                    </div>
                    <div class="col-sm-4">
                        @if(isset($formPermissions[$permission->id]) && ($formPermissions[$permission->id]['other'] == true))
                            ДА
                        @else
                            НЕТ
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    </div>
@endif

@if($form->is_default != 1)
    <div class="btn-toolbar" role="toolbar">
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
@else
    <a class="btn btn-primary" href="{{route('roles.index')}}">Назад</a>
@endif

{{ Form::close() }}