<?php

namespace App\Listeners;

use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;


class LoginSuccessful
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
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->subject= 'login';
        $event->description= 'login Successful';

        Session::flash('login-success' , 'Hello!' .$event->user->first_name . ', Welcome Back!');
        activity($event->subject)
        ->by($event->user)
        ->log($event->description);

    }
}
