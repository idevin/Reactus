{{ Form::model($form, ['url' => $action, 'method' => 'post', 'theme' => 'bootstrap-vertical']) }}
<div class="form-group">
    <label for="title">Сообщение</label>
    {{ Form::textarea('content', $form->content, ['class' => 'form-control', 'id' => 'content']) }}
</div>
<div class="form-group">
    <label for="author">Автор</label>
    {{username($form->author)}}
</div>

<div class="form-group">
    <label for="moder">Модератор</label>
    {{username($form->moderator)}}
</div>

<div class="form-group">
    <label for="rating">Рейтинг</label>
    {{$form->rating}}
</div>

<div class="form-group">
    <label for="rating">На сайте?</label>
    {{ Form::checkbox('moderated', 1, (boolean)$form->content) }}
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
{{ Form::close() }}