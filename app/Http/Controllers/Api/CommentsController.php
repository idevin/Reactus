<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BlogSite;
use App\Models\Comment;
use App\Models\CommentArchive;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Comment as CommentTrait;
use Auth;
use Exception;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * @activity done
     */
    use ArticleTrait;
    use CommentTrait;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Comment::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['add', 'archive', 'batchChangeStatus', 'batchDelete',
            'batchMove', 'delete', 'moderate', 'pin', 'unpin', 'update']);
    }

    /**
     * @api {POST} /api/comments/add Добавление комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} o_id ID обьекта
     * @apiParam {integer} [parent_id] родительский комментарий
     * @apiParam {string} [o] Имя класса обьекта ("App\Models\Article")
     * @apiParam {string} content контент
     *
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->addComment($request, Comment::class, Article::class);
    }

    /**
     * @api {GET} /api/comments/edit Редактирование комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} id ID комментария
     * @apiParam {string} token Ключ пользователя
     *
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        return $this->editComment($request, Comment::class);
    }

    /**
     * @api {POST} /api/comments/batch_delete Мультиудаление комментариев
     * @apiGroup Comments
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} o Обьект (например App\Models\Article)
     * @apiParam {string} o_id ID обьекта с комментариями
     * @apiParam {array} comments Комментарии. Например: comments[1,4,6,88...]
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function batchDelete(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->batchDeleteComment($request);
    }

    /**
     * @api {POST} /api/comments/batch_change_status Мультиизменение статуса комментариев
     * @apiGroup Comments
     *
     * @apiParam {string} token Ключ пользователя
     * @apiParam {string} o Обьект (например App\Models\Article)
     * @apiParam {string} o_id ID обьекта с комментариями
     * @apiParam {array} comments Комментарии. Например: comments[1, 4, 6, 88...]
     * @apiParam {integer} status Статус комментариев (0 - подтвержден, 1 - на модерации)
     * @param Request $request
     * @return array
     */
    public function batchChangeStatus(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->batchChangeStatusComment($request);
    }

    /**
     * @api {POST} /api/comments/batch_move Мульти перенос комментариев
     * @apiGroup Comments
     *
     * @apiParam {string} token Ключ пользователя
     *
     * @apiParam {string} o Обьект (например App\Models\Article)
     * @apiParam {string} o_id ID обьекта с комментариями
     *
     * @apiParam {string} new_o Новый обьект (например App\Models\Article)
     * @apiParam {string} new_o_id Новый ID обьекта с комментариями
     *
     * @apiParam {array} comments Комментарии. Например: comments[1, 4, 6, 88...]
     * @param Request $request
     * @return array
     */
    public function batchMove(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->batchMoveComment($request);
    }

    /**
     * @api {POST} /api/comments/update Обновление комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} id ID комментария
     * @apiParam {string} content контент
     * @apiParam {string} token Ключ пользователя
     *
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->updateComment($request, Comment::class, BlogSite::class);
    }

    /**
     * @api {POST} /api/comments/delete Удаление комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} id ID комментария
     * @apiParam {string} token хеш пользователя
     *
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->deleteComment($request, Comment::class, Article::class);
    }

    /**
     * @api {POST} /api/comments/pin Прикрепление комментария к статье
     * @apiGroup Comments
     *
     * @apiParam {integer} id ID комментария
     *
     * @param Request $request
     * @return array
     */
    public function pin(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->pinComment($request, Comment::class);
    }

    /**
     * @api {POST} /api/comments/unpin Открепление комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} id ID комментария
     *
     * @param Request $request
     * @return array
     */
    public function unpin(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->unpinComment($request, Comment::class);
    }

    /**
     * @api {POST} /api/comments/archive Архивация комментариев
     * @apiGroup Comments
     *
     * @apiParam {integer} article_id ID статьи
     * @apiParam {integer} from_date Дата начала архивации (YYYY-MM-DD HH:MM:SS)
     * @apiParam {string} token Ключ пользователя
     * @param Request $request
     * @return array
     */
    public function archive(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->archiveComment($request, Article::class, Comment::class, CommentArchive::class);
    }

    /**
     * @api {POST} /api/comments/moderate Модерация комментария
     * @apiGroup Comments
     *
     * @apiParam {integer} id comment id
     * @apiParam {integer} moderated moderation status: 0 - false, 1 - true
     * @param Request $request
     * @return array
     */
    public function moderate(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        return $this->moderateComment($request);
    }

    /**
     * @api {GET} /api/comments Список комментариев для обьекта
     * @apiGroup Comments
     * @apiParam {integer} o Класс обьекта (App\Models\Article)
     * @apiParam {integer} o_id ID обьекта
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return $this->commentsIndex($request, Article::class, Comment::class, CommentArchive::class);
    }
}
