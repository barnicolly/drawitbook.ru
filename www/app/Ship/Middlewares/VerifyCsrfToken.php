<?php

declare(strict_types=1);

namespace App\Ship\Middlewares;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * array<int, string>
     */
    protected $except = [
    ];
}
