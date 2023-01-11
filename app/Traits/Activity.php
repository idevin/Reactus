<?php

namespace App\Traits;

use App\Models\Activity as ActivityModel;
use App\Models\BillingTariff;
use App\Models\Site;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

trait Activity
{
    public $object = null;
    public $fromObject = null;
    public $fromObjectId = null;
    public $objectId = null;
    public bool $isApi = false;
    public bool $isSystem = false;
    public string $title = '';
    public string $description = '';
    public array $titleParams = [];
    public array $descriptionParams = [];
    public array $params = [];
    public array $actionsExcluded = [];
    public $activityUser = null;
    public $activityFromUser = null;
    public int $statusCode = 200;
    public $activityError = null;
    public int $isContent = 0;

    public function userWithUserStatus(ActivityModel $activity)
    {
        return $activity->params['status'];
    }

    #[ArrayShape(['object' => "array", 'comment' => "mixed"])]
    public function articleWithComment(ActivityModel $activity): array
    {
        $fromObject = $activity->fromObject();

        if (!empty($fromObject)) {
            $fromObject->makeHidden(['react_data']);
            $fromObject->content = html_entity_decode($fromObject->content);
        }

        return [
            'object' => $this->makeHiddenData($activity->object()),
            'comment' => $fromObject
        ];
    }

    public function makeHiddenData($o): array
    {
        return collect($o)->only(['id', 'title', 'content'])->toArray();
    }

    public function articleWithArticle(ActivityModel $activity): array
    {
        return $this->makeHiddenData($activity->object());
    }

    #[ArrayShape(['object' => "array", 'params' => "array|null"])]
    public function userWithUser(ActivityModel $activity): array
    {
        $object = $this->makeHiddenData($activity->object());

        return [
            'object' => $object,
            'params' => $activity->params
        ];
    }

    #[ArrayShape(['own_comment' => "mixed", 'other_comment' => "array|null"])]
    public function commentWithComment(ActivityModel $activity): array
    {
        $ownObject = $activity->fromObject();
        $otherObject = $this->makeHiddenData($activity->object());

        if ($ownObject) {
            $ownObject->content = html_entity_decode($ownObject->content);
            $otherObject->content = html_entity_decode($otherObject->content);
        } else {
            $ownObject = null;
            $otherObject = null;
        }

        return [
            'own_comment' => $ownObject,
            'other_comment' => $otherObject
        ];
    }

    public function articleWithUser(ActivityModel $activity): array
    {
        return $this->makeHiddenData($activity->object());
    }

    #[ArrayShape(['object' => "array", 'comment' => "mixed"])]
    public function commentWithArticle(ActivityModel $activity): array
    {
        $fromObject = $activity->fromObject();
        $fromObject->content = html_entity_decode($fromObject->content);

        return [
            'object' => $this->makeHiddenData($activity->object()),
            'comment' => $fromObject
        ];
    }

    public function defaultActivity(ActivityModel $activity): ActivityModel
    {
        return $activity;
    }

    #[ArrayShape(['object' => "array", 'params' => "array|null"])]
    public function fieldGroupWithUser(ActivityModel $activity): array
    {
        $object = $this->makeHiddenData($activity->object());

        return [
            'object' => $object,
            'params' => $activity->params
        ];
    }

    #[ArrayShape(['object' => "array", 'params' => "array|null"])]
    public function fieldUserGroupWithUser(ActivityModel $activity): array
    {
        $object = $this->makeHiddenData($activity->object());

        return [
            'object' => $object,
            'params' => $activity->params
        ];
    }

    function getTitleParams(): array
    {
        return $this->titleParams;
    }

    function getDescriptionParams(): array
    {
        return $this->descriptionParams;
    }

    /**
     * @return void|null
     */
    function createActivity()
    {
        $fromUser = $this->getActivityFromUser();
        $user = $this->getActivityUser();

        if (!$user) {
            $user = Auth::user();
        }

        if (!$fromUser) {
            $user = Auth::user();
        }

        $title = $this->getTitle();
        $description = $this->getDescription();
        $params = $this->getParams();
        $isApi = $this->getIsApi();
        $isSystem = $this->getIsSystem();
        $activityStatusCode = $this->getStatusCode();
        $activityError = $this->getActivityError();
        $isContent = $this->getIsContent();

        list($controller, $action, $controllerName) = self::parseRoute(request());

        if (!$action && !$controllerName) {
            return null;
        }

        if (!$title) {
            $title = self::getLocalizedTitle($controllerName, $action);
        }

        if (!$description) {
            $description = self::getLocalizedDescription($controllerName, $action);
        }

        activity(
            $user,
            $fromUser,
            [
                'o' => $this->getObject(),
                'o_id' => $this->getObjectId()
            ], [
            'from_o' => $this->getFromObject(),
            'from_o_id' => $this->getFromObjectId()
        ], $title, $description, $params, request(), $isApi, $isSystem,
            $activityStatusCode, $activityError, $isContent
        );
    }

    /**
     * @return null
     */
    public function getActivityFromUser()
    {
        return $this->activityFromUser;
    }

    /**
     * @param null $activityFromUser
     */
    public function setActivityFromUser($activityFromUser)
    {
        $this->activityFromUser = $activityFromUser;
    }

    /**
     * @return null
     */
    public function getActivityUser()
    {
        return $this->activityUser;
    }

    /**
     * @param null $activityUser
     */
    public function setActivityUser($activityUser)
    {
        $this->activityUser = $activityUser;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    function getParams(): array
    {
        return $this->params;
    }

    function setParams($params)
    {
        $this->params = $params;
    }

    function getIsApi(): bool
    {
        return $this->isApi;
    }

    function setIsApi($boolean)
    {
        $this->isApi = $boolean;
    }

    function getIsSystem(): bool
    {
        return $this->isSystem;
    }

    function setIsSystem($boolean)
    {
        $this->isSystem = $boolean;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return null
     */
    public function getActivityError()
    {
        return $this->activityError;
    }

    /**
     * @param null $activityError
     */
    public function setActivityError($activityError)
    {
        $this->activityError = $activityError;
    }

    function getIsContent(): int
    {
        return $this->isContent;
    }

    public function setIsContent($isContent)
    {
        $this->isContent = $isContent;
    }

    /**
     * @param $request
     * @return array|false|string[]
     */
    public static function parseRoute($request): array|bool|null
    {
        $route = $request->route();

        if ($route) {
            $action = $route->action;
            $data = preg_split('/@/', $action['controller']);
            $onlyControllerName = preg_split('/\\\/', $data[0]);
            $data[] = $onlyControllerName;
            return $data;
        }

        return null;
    }

    public static function getLocalizedTitle($controllerName, $action): string
    {
        return 'activity.title.' . last($controllerName) . '.' . $action;
    }

    public static function getLocalizedDescription($controllerName, $action): string
    {
        return 'activity.description.' . last($controllerName) . '.' . $action;
    }

    function getObject()
    {
        return $this->object;
    }

    function setObject($object)
    {
        $this->object = $object;
    }

    function getObjectId()
    {
        return $this->objectId;
    }

    function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    }

    /**
     * @return null
     */
    function getFromObject()
    {
        return $this->fromObject;
    }

    function setFromObject($fromObject)
    {
        $this->fromObject = $fromObject;
    }

    /**
     * @return null
     */
    function getFromObjectId()
    {
        return $this->fromObjectId;
    }

    function setFromObjectId($fromObjectId)
    {
        $this->fromObjectId = $fromObjectId;
    }

    /**
     * @return array
     */
    public function getActionsExcluded(): array
    {
        return $this->actionsExcluded;
    }

    public function setActionsExcluded(array $actionsExcluded)
    {
        $this->actionsExcluded = $actionsExcluded;
    }

    #[ArrayShape(['suggestions' => "mixed"])]
    public function searchAuthor(Request $request): array
    {
        $query = $request->get('query');

        $users = User::query()->orWhere('username', 'like', "%$query%")
            ->orWhere('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")->get();

        if (count($users) > 0) {
            $users = $users->map(function ($user) {
                return [
                    'value' => username($user),
                    'data' => (string)$user->id
                ];
            });
        }

        return ['suggestions' => $users];
    }

    public function setDefaultActivity($o = User::class): void
    {
        $site = get_site();
        $this->setObject($o);
        $this->setObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setFromObject(Site::class);

        if ($site) {
            $this->setFromObjectId($site->id);
        }

        $this->setIsApi(true);
    }

    public function setUserActivity() {
        $this->setFromObject(User::class);
        $this->setFromObjectId(Auth::user() ? Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
    }

    public function setBillingActivity($o = BillingTariff::class)
    {
        $this->setObject($o);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
    }

    public function setSiteUserActivity($o = Site::class)
    {
        $this->setObject($o);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(false);
        $this->setIsSystem(true);
    }
}