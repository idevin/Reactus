<?php

namespace App\Exceptions;

use App\Traits\Activity;
use App\Traits\Meta;
use App\Traits\Response as ResponseTrait;
use App\Traits\User;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use User;
    use Meta;
    use Activity;


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $e
     * @return void
     * @throws \Throwable
     */
    public function report(\Throwable $e)
    {
        if ($this->shouldReport($e) && app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $e): Response
    {
        if ($e instanceof NotFoundHttpException && $request->is('api/*')) {
            return ResponseTrait::response()->error('Неверный запрос', httpCode: 404);
        }

        $user = $this->getUser($request);

        if ($user) {
            Auth::login($user, true);
        }

        self::getMeta(__METHOD__, $request);

        return parent::render($request, $e);
    }

    public function renderForConsole($output, $e)
    {
        parent::renderForConsole($output, $e);
    }
}
