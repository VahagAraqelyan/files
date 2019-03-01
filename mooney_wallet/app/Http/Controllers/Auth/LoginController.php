<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\user;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $user_auth = $this->find_create_user($user, $provider);

        Auth::login($user_auth,true);

        return redirect($this->redirectTo);
    }

    public function find_create_user($user,$provider){

        $user_auth = User::orWhere(['provider_id'=> $user->id,'email' => $user->email])->first();

        if($user_auth){
            return $user_auth;
        }

        return User::create([
            'name'        => $user->name,
            'email'       => $user->email,
            'provider'    => strtoupper($provider),
            'provider_id' =>$user->id
        ]);
    }
}
