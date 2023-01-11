<?php

namespace App\Http\Controllers;

use App\Models\UserStorageImage;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\User as UserTrait;
use Config;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ImageTool;
use Session;
use Validator;

class UploaderController extends Controller
{
    use Media, UserTrait, Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(UserStorageImage::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/profile/upload-avatar Upload avatar
     * @apiGroup Profile
     * @apiParam {File} avatar
     * @apiParam {string} token ключ пользователя
     *
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        $data = $request->all();

        $validator = $this->createValidator($data, 'image');
        $type = $request->get('type');

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (Auth::user() && !Auth::user()->can('profile_avatar_edit', Auth::user())) {
            return $this->error('Вы не можете редактировать фото');
        }

        $user = $this->publicUser(false);

        switch ($type) {
            case 0:
                $text = 'Вы обновили аватар';
                $imageType = UserStorageImage::IMAGE;
                break;

            case 1:
                $text = 'Вы обновили задний фон';
                $imageType = UserStorageImage::BACKGROUND;
                break;

            default:
                $text = 'Вы обновили профиль';
                $imageType = UserStorageImage::IMAGE;
                break;
        }

        if (!empty($data['image']) && is_array($data['image'])) {
            $this->saveUserStorage($user, $data['image'], $imageType);
            $data['image'] = basename($data['image']['url']);
            $imageUrl = $data['image'];
        } else {
            $this->deleteUserStorageImage($user, $imageType);
            $imageUrl = null;
        }

        UserStorageImage::flushCache();

        $image = null;

        switch ($imageType) {
            case UserStorageImage::IMAGE:
                if (!empty($user->thumbs)) {

                    $image = [
                        'id' => $user->thumbs['id'],
                        'title' => $user->thumbs['title'],
                        'description' => $user->thumbs['description'],
                        'url' => $user->thumbs['url'],
                        'url_miniature' => $user->thumbs['thumb150x150'],
                        'type' => $imageUrl,
                        'original' => $user->thumbs['original']
                    ];
                }
                break;
            case UserStorageImage::BACKGROUND:
                if (!empty($user->background)) {
                    $image = [
                        'id' => $user->background['id'],
                        'title' => $user->background['title'],
                        'description' => $user->background['description'],
                        'url' => $user->background['url'],
                        'url_miniature' => $user->background['thumbs']['thumb1920x1080'],
                        'type' => $imageUrl,
                        'original' => $user->background['thumbs']['original']
                    ];
                }
                break;
        }

        if ($image) {
            $image['url'] = $image['url'] . '?' . generate_code(3, true);
            $image['url_miniature'] = $image['url_miniature'] . '?' . generate_code(3, true);
        }
        $profileUserString = 'profileUser.' . $user->id;

        Session::forget($profileUserString);

        return $this->success(compact('image'), $text);
    }

    protected function createValidator($data, $field)
    {
        return Validator::make(
            $data,
            [
                $field => 'required',
                'type' => 'required'
            ],
            [
                $field . '.required' => 'Поле ' . $field . ' обязательно для заполнения',
                'type.required' => 'Не задан тип изображения'
            ]
        );
    }
}
