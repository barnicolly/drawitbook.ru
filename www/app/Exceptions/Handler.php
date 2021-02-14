<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $url = $request->url();
            if (mb_stripos($url, '/en/risunki-po-kletochkam') !== false) {
                $redirectTo = str_ireplace('en/risunki-po-kletochkam', 'en/pixel-arts', $url);
            } elseif (mb_stripos($url, '/ru/pixel-arts') !== false) {
                $redirectTo = str_ireplace('ru/pixel-arts', 'ru/risunki-po-kletochkam', $url);
            }
            if (!empty($redirectTo)) {
                return redirect($redirectTo);
            }
        }
        return parent::render($request, $exception);
    }
}
