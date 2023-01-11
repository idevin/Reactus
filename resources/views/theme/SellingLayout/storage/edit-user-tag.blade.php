<form action="#" method="post" class="edit-user-tag-form">
    <div class="error-user-tag" data-id="{{$tag->id}}"></div>
    <input type="text" data-id="{{$tag->id}}" name="name" class="tag_name" value="{{strip_tags($tag->name)}}">
    <input type="submit" name="ok" value="ok">
</form>