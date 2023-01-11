<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\StorageTag;
use App\Traits\Activity;

class StorageTagController extends Controller
{
    use Activity;

    public static $user = null;

    public function __construct()
    {
        parent::__construct();
        static::$user = \Auth::user();
        \View::share('user', static::$user);
        $this->setSiteUserActivity(StorageTag::class);
    }

    public function deleteTag($tagId)
    {
        $success = false;
        $tag = $this->findTag($tagId);

        if ($tag) {
            $tag->delete();
            $success = true;
        }

        return ['success' => $success];
    }

    private function findTag($tagId)
    {
        $tag = StorageTag::where(['id' => $tagId, 'user_id' => static::$user->id])->first();
        return $tag;
    }

    public function editTag($tagId)
    {
        $success = false;
        $name = \Request::input('name', null);
        $tag = $this->findTag($tagId);

        if ($tag) {
            $success = true;
            $tag->update([
                'name' => $name
            ]);
        }

        return ['success' => $success];
    }
}
