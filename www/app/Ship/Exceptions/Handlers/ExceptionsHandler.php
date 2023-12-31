<?php

declare(strict_types=1);

namespace App\Ship\Exceptions\Handlers;

use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class ExceptionsHandler extends LaravelExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(static function (Throwable $e): void {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception): Response
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
