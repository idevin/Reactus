<div class="row user-tag" data-tag_id="{{$tag->id}}">
    <div class="col-sm-6">
        <p>
            <input type="checkbox" name="tag_{{$tag->id}}" class="choosen-tag" value="{{$tag->id}}">
            <a href="#" class="filter-tag" data-id="{{$tag->id}}">{{$tag->name}}</a>
            <sup>{{$tag->files()->count()}}</sup>
        </p>
    </div>
    <div class="col-sm-6">
        <a href="#" class="edit-user-storage-tag" data-id="{{$tag->id}}">редактировать</a>
        /
        <a href="#" class="remove-user-storage-tag" data-id="{{$tag->id}}">удалить</a>
    </div>
</div>