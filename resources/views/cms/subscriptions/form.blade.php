{{ Form::model($form, ['url' => route($action, ['subscriptions' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'novalidate' => 'novalidate']) }}

<div class="form-group clearfix">
    {{ Form::label('name', 'Логин', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        <a href="{{ route('cms.users.edit', ['user_id' => $form->user->id]) }}" target="_blank">
            {{username($form->user)}}
            @if($form->user->email)
                | {{$form->user->email}}
            @endif
            @if($form->user->phone)
                | {{$form->user->phone}}
            @endif
        </a>
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Дата/Время начала', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::datetime('created_at', date('Y-m-d H:i', strtotime($form->created_at)), ['class' => 'form-control', 'id' => 'created_at']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('ends_at', 'Дата/Время окончания', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::datetime('ends_at', date('Y-m-d H:i', strtotime($form->ends_at)), ['class' => 'form-control', 'id' => 'created_at']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('next_write_off', 'Дата следующего списания', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::datetime('next_write_off', date('Y-m-d H:i', strtotime($form->next_write_off)), ['class' => 'form-control', 'id' => 'created_at']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('autorenew', 'Автопродление?', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::checkbox('autorenew', 1, (int)$form->autorenew == 1 ? true : false) }}
    </div>
</div>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}