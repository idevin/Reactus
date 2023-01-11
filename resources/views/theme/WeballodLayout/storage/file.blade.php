<div class="row file" data-id="{{$file->id}}">
    <div class="col-sm-8">
        <input type="checkbox" class="choosen-files" name="file_{{$file->id}}" value="{{$file->id}}">
        {{--<img src="http://placehold.it/100x100?text={{$file->extension}}">--}}
        <br>
        {{$file->filename}}.{{$file->extension}}
        <br>
        {{format_bytes($file->size)}}
        <br>
        @if($file->recycle == 0)
            <a href="#" data-id="{{$file->id}}" class="delete-file">удалить</a>
        @else
            <a href="#" data-id="{{$file->id}}" class="undelete-file">убрать из корзины</a> |
            <a href="#" data-id="{{$file->id}}" class="delete-bin-file">удалить файл</a>
        @endif

        <br>

        @if($file->favorite == 0)
            <a href="#" data-id="{{$file->id}}" class="favorite-file">добавить в избранное</a>
        @else
            <a href="#" data-id="{{$file->id}}" class="unfavorite-file">убрать из избранного</a>
        @endif

        <br>

        <a href="/api/storage/download/{{$file->id}}" target="_blank">скачать</a>

        <hr>
    </div>
    <div class="col-sm-4">
        Теги:
        <div class="storage-file-tags" data-id="{{$file->id}}">
            @if(count($file->tags) > 0)
                @foreach($file->tags as $tag)
                    @include(theme('storage.tag'))
                @endforeach
            @endif

            <form action="" class="add-storage-tag" method="post">
                <input type="text" value="">
                <input type="hidden" name="file_id" value="{{$file->id}}">
                <button>добавить</button>
            </form>

        </div>
    </div>
</div>
