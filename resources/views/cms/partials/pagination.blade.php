<div class="pull-left">
    <div class="" style="display:inline-block; float: left;">
        {{$fields->links()}}
    </div>
    <div class="pagination" style="display:inline-block; float: right;padding-left:5px;">
        <select name="limit" class="form-control set-limit">
            @foreach(\App\Models\Article::$adminLimits as $limit)
                @if(request('limit') && request('limit') == $limit)
                    <option value="{{$limit}}" selected="selected">{{$limit}}</option>
                @else
                    <option value="{{$limit}}">{{$limit}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>