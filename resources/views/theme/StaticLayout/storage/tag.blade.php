<span class="storage-tag-wrapper" data-tag_id="{{$tag->id}}">
                    <a class="storage-tag" href="/api/storage/tag/{{$tag->name}}" data-tag_id="{{$tag->id}}">{{$tag->name}}</a>
                    <sup><a class="remove-storage-tag" href="/api/storage/remove_tag"
                            data-file_id="{{$file->id}}"
                            data-id="{{$tag->id}}">x</a></sup>
</span>