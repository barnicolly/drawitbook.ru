<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

final class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $roles = Auth::user()->roles()->pluck('name')->toArray();
        if (in_array('Admin', $roles)) {
            session(['is_admin' => true]);
        }
        session(['roles' => $roles]);
    }
}
