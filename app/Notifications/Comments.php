<?php

namespace App\Notifications;


use App\Models\BlogArticle;
use App\Models\BlogComment;
use App\Models\BlogCommentArchive;
use App\Models\Comment;
use App\Models\CommentArchive;
use Illuminate\Pagination\Paginator;

class Comments
{

    public function add($from, $client, $message)
    {
        if (!empty($message['o']) && !empty($message['o_id'])) {

            $data = $this->index($message);

            $data = json_decode($data, true);

            return $client->send(json_encode(['data' => $data, 'action' => 'comments_add']));

        } else {
            return $from->send($this->error('Не заданы параметры o, o_id', null, 400, true));
        }
    }

    public function index($data): bool|string
    {
        $objectId = isset($data['o_id']) ? (int)$data['o_id'] : null;
        $o = $data['o'] ?? null;


        if (!$objectId) {
            return $this->error('Неверный параметр o_id', null, 400, true);
        }

        if (!$o) {
            return $this->error('Неверный параметр o', null, 400, true);
        }

        $article = app($o);
        $article = $article->find($objectId);

        if (!$article) {
            return $this->error('Коментариев не найдено...', null, 400, true);
        }

        $comments = [];
        $commentsPinned = [];
        $commentArchive = [];

        if (isset($article->settings['allow_comments']) && (int)$article->settings['allow_comments'] == 1) {
            $commentsArray = $this->loadComments($article);
            $comments = $commentsArray['comments'];
            $commentsPinned = $commentsArray['commentsPinned'];
            $commentArchive = $article->commentArchive;
        }

        $article_id = $article->id;

        return json_encode(compact('comments', 'commentsPinned', 'commentArchive', 'article_id'));
    }

    protected function loadComments($article): array
    {
        $comments = [];

        $models = $this->getModels($article);

        $sortOrder = $article->sort_comments;

        $alias = $models['article']::$sortComments[1]['alias'];
        $sort = request('sort', $models['article']::COMMENTS_SORT_BY_DATE);

        if (in_array($sortOrder, array_keys($models['article']::$sortComments))) {
            $alias = $models['article']::$sortComments[$sortOrder]['alias'];
        }

        $commentArchive = $models['commentArchive']::where('article_id', $article->id)->first();

        foreach (['comments', 'modifiedComments'] as $paginations) {
            $$paginations = $models['comment']::with('author')
                ->whereObject($models['article'])->whereObjectId($article->id);

            if ($commentArchive) {
                $$paginations = $$paginations->where('created_at', '>', $commentArchive->from_date);
            }

            $object = $$paginations;

            if (isset($article->settings['moderate_comments']) &&
                (int)$article->settings['moderate_comments'] == 1) {
                $object->whereStatus($models['comment']::STATUS_APPROVED);
                $$paginations = $object;
            }

            $total = $$paginations->count();
            $total = ceil($total / 10);

            Paginator::currentPageResolver(function () use ($total) {
                return $total;
            });

            $$paginations = $$paginations->whereNull('pinned')
                ->orderBy($alias, 'ASC')
                ->paginate(10)->appends([
                    'sort' => $sort
                ]);
        }

        $commentsPinned = $models['comment']::whereObject($models['article'])->whereObjectId($article->id)
            ->wherePinned(1)->get();

        return compact('comments', 'commentsPinned');
    }

    public function getModels($fromArticle)
    {
        $articleClass = get_class($fromArticle);
        $commentClass = Comment::class;
        $commentArchiveClass = CommentArchive::class;

        if ($articleClass == BlogArticle::class) {
            $commentClass = BlogComment::class;
            $commentArchiveClass = BlogCommentArchive::class;
        }

        $data = [
            'article' => $articleClass,
            'comment' => $commentClass,
            'commentArchive' => $commentArchiveClass
        ];

        return $data;
    }
}