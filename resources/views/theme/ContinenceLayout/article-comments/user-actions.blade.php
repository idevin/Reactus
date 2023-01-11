{{--<a href="#" class="navbar-user-action"><span class="icon icon-chat"></span></a>--}}
{{--<a href="#" class="navbar-user-action"><span class="icon icon-gift"></span></a>--}}

<a href="#" class="navbar-user-action" data-toggle="modal" data-authorId="{{encrypt($comment->author->id, false)}}" data-id="{{encrypt($comment->id)}}"
   data-cId="{{$comment->id}}" data-target="#complaint-comment-user"><span
            class="icon icon-complaint-small"></span></a>

{{--<a href="#" class="navbar-user-action"><span class="icon icon-plus-circle"></span></a>--}}
