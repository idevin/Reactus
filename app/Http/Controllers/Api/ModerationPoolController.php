<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Complain;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Utils;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModerationPoolController extends Controller
{
    /**
     * @activity done
     */
    use Utils;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Complain::class);
        $this->setUserActivity();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/pool/index Get moderation articles and comments
     * @apiGroup Moderators
     *
     */
    public function index()
    {
        $data = [
            'moderationStatuses' => Complain::statuses()
        ];

        $complains = Complain::where(['status' => Complain::STATUS_ON_MODERATION])->orderBy('id', 'DESC');
        $complains->paginate(5);
        $complains = Utils::transformUrl($complains);

        foreach ($complains->get() as $complain) {
            $method = null;

            if (in_array($complain->object, Complain::$types)) {
                $method = Complain::getMethod($complain->object);
                $data['data'][] = $this->$method($complain);
            }
        }

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/pool/answer Answer on complain
     * @apiGroup Moderators
     *
     * @apiParam {integer} id ID Обьекта
     * @apiParam {string} answer Ответ на жалобу
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function answer(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $answer = $request->input('answer');
        $user = $request->input('user');

        $complain = Complain::find($id);
        $data = [
            'success' => false,
            'error' => '',
            'notice' => ''
        ];

        if (!$complain) {
            $data['error'] = 'Жалоба не найдена...';
        } else {
            if ($user && $user->can('moderpool_complain_answer', $complain)) {
                if (!empty(trim($answer))) {
                    $complain->update([
                        'answer' => $answer,
                        'moderator_id' => $user->id
                    ]);

                    $data['success'] = true;
                    $data['notice'] = 'Ответ отправлен.';
                    $data['complain'] = $complain;

                } else {
                    $data['error'] = 'Напишите ответ...';
                }
            } else {
                $data['error'] = 'Вы не имеете прав для этого действия';
            }
        }

        return $this->success($data);
    }

    private function article($complain)
    {
        /** @var \App\Models\Complain $complain */
        $article = $complain->object();

        $data = $this->getData($article);

        return [
            'id' => $article->id,
            'type' => Complain::getMethod(Article::class),
            'domain' => $article->site->domain,
            'section' => [
                'name' => $article->section->title,
                'url' => route_to_section($article->section)
            ],
            'moderationStatus' => $complain->status,
            'article' => [
                'status' => $article->status,
                'draft' => $article->draft,
                'complainsCount' => $data['articleComplains']
            ],
            'author' => [
                'url' => route_to_public_profile($data['author']),
                'name' => username($data['author'])
            ],
            'comments' => [
                'total' => $data['commentsCount'],
                'onModeration' => $data['onModeration']->count(),
                'data' => $data['onModeration']
            ],
            'complain' => $complain
        ];
    }

    public function getData($article): array
    {
        $comments = $article->comments;
        $commentsCount = $comments->count();

        $onModeration = $comments->reject(function ($comment) {
            return $comment->moderated != Comment::STATUS_ON_MODERATION;
        })->transform(function ($item) {

            $item->content = html_entity_decode($item->content);
            return $item;
        });

        $author = $article->author;

        $articleComplains = $article->complains($article->id)->count();

        return compact('articleComplains', 'author', 'onModeration', 'commentsCount');
    }

    private function comment($complain)
    {
        $comment = $complain->object();
        $data = null;

        if ($comment) {
            $article = $comment->article;

            $data = $this->getData($article);

            $data = [
                'id' => $comment->id,
                'type' => Complain::getMethod(Comment::class),
                'domain' => $article->site->domain,
                'section' => [
                    'name' => $article->section->title,
                    'url' => route_to_section($article->section)
                ],
                'moderationStatus' => $complain->status,
                'article' => [
                    'status' => $article->status,
                    'draft' => $article->draft,
                    'complainsCount' => $data['articleComplains']
                ],
                'author' => [
                    'url' => route_to_public_profile($data['author']),
                    'name' => username($data['author'])
                ],
                'comments' => [
                    'total' => $data['commentsCount'],
                    'onModeration' => $data['onModeration']->count(),
                    'data' => $data['onModeration']
                ],
                'complain' => $complain
            ];
        }

        return $data;
    }
}