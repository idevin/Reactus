<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Site;
use Auth;
use Conner\Tagging\Taggable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TagsController extends Controller
{
    /**
     * @activity done
     */
    use Site;
    use Taggable;
    use Activity;

    public static User|null $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Tag::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/tags/search Поиск по меткам
     * @apiGroup Tags
     *
     * @apiParam {string} term  input name
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('term', null);

        if (!$term) {
            return $this->error('Не задан параметр для поиска...');
        }

        if (mb_strlen($term) <= 2) {
            return $this->error('Параметр поиска должен быть не меньше 3-х символов');
        }

        $tags = Tag::where('name', 'LIKE', '%' . $term . '%')->get();

        $data = ['term' => $term, 'tags' => $tags];

        return $this->success($data);
    }
}