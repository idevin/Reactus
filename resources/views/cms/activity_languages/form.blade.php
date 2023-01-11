{{ Form::model($form, ['url' => route($action, ['activity_languages' => $form->id], false), 'method' => 'post', 'theme' => 'bootstrap-vertical']) }}

<div class="form-group">
    <label for="author">
        <h3>Системный перевод &mdash; {{$form->activity_key}}</h3>
        {{$form->translated}}
    </label>
</div>

@foreach(config('languages.default') as $prefix)
    <div class="form-group">
        <label for="title">Перевод ({{ucwords($prefix)}})</label>
        {{ Form::input('text', 'title[' .  $titles[$prefix]->id . '][' . $prefix . ']', $titles[$prefix]->translated, ['class' => 'form-control']) }}
    </div>
@endforeach

<hr>

<div class="form-group">
    <label for="author">
        <h3>Перевод для пользователя</h3>
        {{$form->translated}}
    </label>
</div>

@foreach(config('languages.default') as $prefix)
    <div class="form-group">
        <label for="title">Перевод ({{ucwords($prefix)}})</label>
        {{ Form::input('text', 'description[' .  $descriptions[$prefix]->id . '][' . $prefix . ']', $descriptions[$prefix]->translated, ['class' => 'form-control']) }}
    </div>
@endforeach

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
{{ Form::close() }}