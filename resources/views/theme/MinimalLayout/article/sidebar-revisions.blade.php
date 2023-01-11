@if(count($revisions) > 0)
    <div class="topic-list-item revision">
        <div class="topic-title large">
            <strong>История файла</strong>
        </div>

        <div class="topic-body">
            <div class="file-history">

                @foreach($revisions as $revision)
                    <div class="file-history-item">
                        <p>{{getFormatedDate($revision->created_at)}}</p>

                        <a href="{{route('article.revision', ['id' => $revision->id])}}" class="file-history-item-link">{{$revision->title}}</a>

                        <p>{{$revision->count_images}} фото, ? опроса, {{$revision->count_symbols}} сивмолов текста</p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endif
