<?php

namespace App\Containers\Authorization\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
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
