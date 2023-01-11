<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Complain;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;
use App\Traits\Activity;

class ComplainsController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public static $user = null;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Complain::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['article', 'comment', 'complain']);
    }

    public function article(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        $data = $this->complain($request, Article::class);
        return compact('data');
    }

    public function comment(Request $request)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        $data = $this->complain($request, Comment::class);
        return compact('data');
    }

    public function complain(Request $request, $object)
    {
        $this->setIsSystem(false);
        $this->setParams($request->all());
        $this->createActivity();

        $objectId = $request->get('object_id', null);
        $onUserId = $request->get('on_user_id', null);
        $content = $request->get('message', null);
        $complainOptions = $request->get('reason', null);
        $success = true;
        $complain = null;
        $parentObjectId = 0;

        if ($object && $objectId && $onUserId && $complainOptions && $content) {
            $onUserId = decrypt($onUserId, false);
            $objectId = decrypt($objectId, false);

            if ($object == Comment::class) {
                $comment = Comment::find($objectId);
                $parentComplain = Complain::where(['object_id' => $parentObjectId, 'object' => $comment->object])->get()->first();

                if ($parentComplain) {
                    $parentObjectId = $comment->object()->id;
                }
            }

            foreach ($complainOptions as $complainOption) {
                Complain::create([
                    'user_id' => Auth::user()->id,
                    'complain_option_id' => $complainOption,
                    'on_user_id' => $onUserId,
                    'object' => $object,
                    'object_id' => $objectId,
                    'content' => $content,
                    'parent_object_id' => $parentObjectId,
                    'moderator_id' => 0,
                    'status' => Complain::STATUS_ON_MODERATION
                ]);
            }
        }

        return $this->success($success);
    }
}