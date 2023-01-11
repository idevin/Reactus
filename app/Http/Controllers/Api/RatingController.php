<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Section;
use App\Traits\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public static $user = null;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Rating::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['makeRevote', 'unvote']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     * @api {POST} /api/rating/article/{id}/set  Установка рейтинга для статьи
     * @apiGroup Rating
     *
     * @apiParam {Number} ratingValue value for rating
     *
     */
    public function setArticle($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $ratingValue = (int)$request->get('ratingValue');
        $rating = 0.0;
        $error = null;

        if ($article) {
            if (in_array($ratingValue, Article::ratingValues()) && Auth::user()) {
                if (!$this->alreadyVoted($article->id, Article::class)) {
                    if (Auth::user()->id == $article->author_id) {
                        $error = 'Вы не можете голосовать за свою статью';
                    } else {
                        Rating::create([
                            'user_id' => Auth::user()->id,
                            'object' => Article::class,
                            'object_id' => $article->id,
                            'rating_value' => $ratingValue]);
                    }
                } else {
                    $error = 'Вы поменяли голос...';
                    $this->makeRevote($article->id, Article::class, $ratingValue);
                }

                $article->rating = Article::calculateRating($article);
                $article->update();
                if ($article->section) {
                    $article->section->rating = Section::calculateRating($article->section);
                    $article->section->update();
                }

            } else {
                $error = 'Голос не засчитан...';
            }
        } else {
            $error = 'Статья не найдена';
        }

        if ($article) {
            $rating = rating_format($article->rating);
        }

        $user = Auth::user();
        $data = compact('article', 'ratingValue', 'rating', 'error', 'user');

        if (!$data['error']) {
            if (!empty($article->author->email) && filter_var($article->author->email, FILTER_VALIDATE_EMAIL)) {
                sendEmail($article->author->email, 'Вам поставили рейтинг к статье', $data, 'article-rating-set');
            }
        }

        return $this->success($data);
    }

    public function alreadyVoted($id, $objectClass)
    {
        if (Auth::user()) {
            $rating = Rating::where('user_id', '=', Auth::user()->id)
                ->where('object_id', '=', $id)
                ->where('object', '=', $objectClass)->get()->first();

            if ($rating) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    private function makeRevote($id, $class, $ratingValue)
    {
        $rating = Rating::where(['object' => $class, 'object_id' => $id, 'user_id' => Auth::user()->id])->get()->first();
        if ($rating) {
            $rating->update(['rating_value' => $ratingValue]);

            $this->setIsSystem(false);
            $this->setParams($rating->toArray());
            $this->createActivity();

        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     * @api {POST} /api/rating/comment/{id}/set  Установка рейтинга для коментария
     * @apiGroup Rating
     *
     * @apiParam {Number} ratingValue значение рейтинга
     *
     */
    public function setComment($id, Request $request)
    {
        $comment = Comment::find($id);
        $ratingValue = (int)$request->get('ratingValue');
        $error = null;
        if ($comment) {
            if (!$this->alreadyVoted($comment->id, Comment::class)) {
                if (in_array($ratingValue, Comment::ratingValues())) {
                    if (Auth::user()->id == $comment->author_id) {
                        return $this->success('Вы не можете голосовать за свой комментарий');
                    } else {
                        Rating::create([
                            'user_id' => Auth::user()->id,
                            'object' => Comment::class,
                            'object_id' => $comment->id,
                            'rating_value' => $ratingValue]);
                    }
                } else {
                    return $this->success('Голос не засчитан...');
                }
            } else {
                $this->makeRevote($comment->id, Comment::class, $ratingValue);
            }

            $comment->rating = Comment::calculateRating($comment);
            $comment->update();

        } else {
            return $this->success('Комментарий не найден...');
        }

        if ($comment) {
            $rating = rating_format($comment->rating);
        }

        $user = Auth::user();
        $data = compact('comment', 'ratingValue', 'rating', 'error', 'user');

        if (!$data['error']) {
            if (!empty($comment->author->email) && filter_var($comment->author->email, FILTER_VALIDATE_EMAIL)) {
                sendEmail($comment->author->email, 'Вам поставили рейтинг к комментарию', $data, 'comment-rating-set');
            }
        }

        return $this->success($data);
    }

    /**
     * @param $id
     * @return array
     * @api {POST} /api/rating/comment/{id}/unvote  Отмена голоса для комментария
     * @apiGroup Rating
     *
     * @apiParam {Number} id ID статьи
     *
     */
    public function unvoteComment($id)
    {

        $data = $this->unvote(Comment::class, $id);

        return $this->getResponse($data);
    }

    private function unvote($object, $id)
    {
        $error = null;
        $rating = 0.0;

        $objectData = $object::find($id);

        $oRating = Rating::whereUserId(Auth::user()->id)->whereObject($object)
            ->where('object_id', $id)->first();

        if ($objectData) {
            if ($oRating) {
                if ($oRating->user_id == Auth::user()->id) {
                    $oRating->delete();
                } else {
                    $error = 'Невалидный голос...';
                }
            } else {
                $error = 'Голос уже отменен Вами...';
            }

            $rating = $object::calculateRating($objectData);

            $this->setIsSystem(false);
            $this->setParams($oRating->toArray());
            $this->createActivity();

            $objectData->update(['rating' => $rating]);

        } else {
            $error = 'Обьект не найден...';
        }

        $rating = rating_format($rating);

        return [
            'error' => $error,
            'rating' => $rating,
            'comment' => $objectData->toArray()
        ];
    }

    public function getResponse($data): JsonResponse|bool|string
    {
        if (isset($data['error'])) {
            return $this->error($data['error']);
        } else {
            return $this->success($data);
        }
    }

    /**
     * @param $id
     * @return array
     * @api {POST} /api/rating/article/{id}/unvote  Отмена голоса для статьи
     * @apiGroup Rating
     *
     * @apiParam {Number} id ID статьи
     *
     */
    public function unvoteArticle($id): JsonResponse|bool|array|string
    {
        $data = $this->unvote(Article::class, $id);

        return $this->getResponse($data);
    }
}