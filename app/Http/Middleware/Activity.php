<?php

namespace App\Http\Middleware;

use App\Traits\Activity as ActivityTrait;
use Closure;
use Illuminate\Http\Request;


class Activity
{
    use ActivityTrait;

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (php_sapi_name() != 'cli') {
            $user = $request->user();

            $activity = (new class {
                use ActivityTrait;
            });

            list($controller, $action, $controllerName) = $activity::parseRoute($request);

            $controllerObject = app($controller);

            if (in_array(ActivityTrait::class, array_keys(class_uses($controllerObject))) &&
                !in_array($action, $controllerObject->getActionsExcluded())) {

                $statusCode = $response->getStatusCode();

                $title = $activity::getLocalizedTitle($controllerName, $action);
                $description = $activity::getLocalizedDescription($controllerName, $action);

                $params = $controllerObject->getParams();

                $isApi = $controllerObject->getIsApi();
                $isSystem = $controllerObject->getIsSystem();

                if ($statusCode == 200) {
                    activity(
                        $user,
                        $user,
                        [
                            'o' => $controllerObject->getObject(),
                            'o_id' => $controllerObject->getObjectId()
                        ], [
                        'from_o' => $controllerObject->getFromObject(),
                        'from_o_id' => $controllerObject->getFromObjectId()
                    ], $title, $description, $params, $request, $isApi, $isSystem
                    );
                }
            }
        }

        return $response;
    }
}
