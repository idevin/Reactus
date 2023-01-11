<div class="modal modal-middle modal-complaint no-border fade  js-modal-clear" id="complaint-article-user" tabindex="-1"
     role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class="icon icon-error"></span>
            </button>

            <div class="modal-header">
                <div class="modal-icon">
                    <span class="icon icon-complaint-big"></span>
                </div>

                <p><strong>Пожаловаться на статью</strong></p>
            </div>


            <div class="modal-body">
                <p>
                    <strong>Статья:</strong> {{$article->title}}
                </p>

                @if($article->author)
                    <p>
                        <strong>Автор:</strong> {{$article->author->first_name}} {{$article->author->username}} {{$article->author->last_name}}
                    </p>
                @endif

                <p>
                    <strong>URL:</strong>
                    <span class="complain-url">{{route('article.show', ['title' => $article->slug, 'id' => $article->id])}}</span>
                </p>

                <form class="modal-complaint-form article js-complaint-form js-disable-dynamic" novalidate>

                    @if($article->author)
                        <input type="hidden" name="on_user_id" value="{{encrypt($article->author->id, false)}}">
                    @endif

                    <input type="hidden" name="object_id" value="{{encrypt($article->id)}}">

                    <div class="form-group">
                        <select class="select-tags no-border" multiple data-placeholder="Причина" name="reason[]"
                                data-validation="required"
                                data-validation-error-msg="Укажите причину">

                            @foreach($complainOptions as $option)
                                <option value="{{$option->id}}">{{$option->title}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
              <textarea class="form-control no-border" name="message" placeholder="Комментарий"
                        data-validation="required"
                        data-validation-error-msg="Напишите комментарий"></textarea>
                    </div>

                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-lg submit-article-complain">Отправить
                                    жалобу
                                </button>
                            </div>

                            <button type="button" class="btn btn-dark btn-lg" data-dismiss="modal">Отмена</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-middle modal-complaint no-border fade  js-modal-clear" id="complaint-comment-user" tabindex="-1"
     role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class="icon icon-error"></span>
            </button>

            <div class="modal-header">
                <div class="modal-icon">
                    <span class="icon icon-complaint-big"></span>
                </div>

                <p><strong>Пожаловаться на комментарий</strong></p>
            </div>


            <div class="modal-body">
                <p>
                    <strong>Статья:</strong> {{$article->title}}
                </p>

                @if($article->author)
                    <p>
                        <strong>Автор:</strong> {{$article->author->first_name}} {{$article->author->username}} {{$article->author->last_name}}
                    </p>
                @endif

                <p>
                    <strong>URL:</strong>

                    <input type="hidden" class="article-comment-url"
                           value="{{route('article.show', ['title' => $article->slug, 'id' => $article->id])}}"
                           name="complaint-url">

                    <span class="comment-url">{{route('article.show', ['title' => $article->slug, 'id' => $article->id])}}</span>
                </p>

                <form class="modal-complaint-form comment js-complaint-form js-disable-dynamic" novalidate>

                    @if($article->author)
                        <input type="hidden" class="on-user-id" name="on_user_id"
                               value="{{encrypt($article->author->id)}}">
                    @endif

                    <input type="hidden" class="object-id" name="object_id" value="{{encrypt($article->id)}}">

                    <div class="form-group">
                        <select class="select-tags no-border" multiple data-placeholder="Причина" name="reason[]"
                                data-validation="required"
                                data-validation-error-msg="Укажите причину">

                            @foreach($complainOptions as $option)
                                <option value="{{$option->id}}">{{$option->title}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
              <textarea class="form-control no-border" name="message" placeholder="Комментарий"
                        data-validation="required"
                        data-validation-error-msg="Напишите комментарий"></textarea>
                    </div>

                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-lg submit-comment-complain">Отправить
                                    жалобу
                                </button>
                            </div>

                            <button type="button" class="btn btn-dark btn-lg" data-dismiss="modal">Отмена</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>