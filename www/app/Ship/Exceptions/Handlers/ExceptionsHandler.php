<?php

namespace App\Ship\Exceptions\Handlers;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionsHandler extends LaravelExceptionHandler
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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $redirectTo = $this->checkKnownRedirect($request->url());
            if (!empty($redirectTo)) {
                return redirect($redirectTo);
            }
        }
        return parent::render($request, $exception);
    }

    private function checkKnownRedirect(string $url): ?string
    {
        $redirectTo = null;
        if (mb_stripos($url, '/en/risunki-po-kletochkam') !== false) {
            $redirectTo = str_ireplace('en/risunki-po-kletochkam', 'en/pixel-arts', $url);
        } elseif (mb_stripos($url, '/ru/pixel-arts') !== false) {
            $redirectTo = str_ireplace('ru/pixel-arts', 'ru/risunki-po-kletochkam', $url);
        }
        return $redirectTo;
    }
}
