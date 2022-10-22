<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Activitylog\Traits\LogsActivity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,LogsActivity;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected static $logAttributes = [];
    protected $redirectTo = RouteServiceProvider::HOME;

    // protected static $logAttributes = ['name', 'created_by', 'updated_by'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have successfully logged in ";
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
