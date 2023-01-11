<?php

namespace App\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use JSON;

trait Response
{
    public static function checkXmlHttpRequest($errors): \Illuminate\Http\Response|Application|ResponseFactory
    {
        if (\Request::isXmlHttpRequest()) {
            return Response::response()->error($errors['error']);
        } else {
            return response($errors, 401);
        }
    }

    public static function response(): object
    {
        return new class {
            use Response;
        };
    }

    /**
     * @param $errors
     * @param null $data
     * @param int $httpCode
     * @param null $asJson
     * @param array $headers
     * @return false|JsonResponse|string
     */
    public function error($errors, $data = null, $httpCode = 400, $asJson = null, $headers = []):
    bool|JsonResponse|string
    {
        if (is_string($errors)) {
            $errors = ['message' => $errors];
        }

        if (in_array(Activity::class, array_keys(class_uses($this)))) {
            $this->setIsSystem(true);
            $this->setStatusCode($httpCode);
            $this->setActivityError($errors);
            $this->createActivity();
        }

        $json = [
            'result' => 'error',
            'errors' => $errors,
            'code' => $httpCode,
            'data' => $data
        ];

        if (!$asJson) {
            return response()->json($json, $httpCode, $headers);
        } else {
            return json_encode($json);
        }
    }

    /**
     * @param null $data
     * @param null $message
     * @param array $headers
     * @return JsonResponse
     */
    public function success($data = null, $message = null, $headers = []): JsonResponse
    {
        $json = [
            'result' => 'success',
            'code' => 200,
            'data' => $data,
            'message' => ''
        ];

        if ($message) {
            $json['message'] = $message;
        }

        if (is_string($data)) {
            $json['message'] = $data;
            $json['data'] = [];
        }

        return response()->json($json, 200, $headers);
    }
}
