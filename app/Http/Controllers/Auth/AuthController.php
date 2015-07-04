<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectPath = '/';

    private $user;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, User $user)
	{
        $this->user = $user;
        $this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username'=>'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username'=>$data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_maintainer'=>false,

        ]);
    }
    public function facebookLogin()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function facebookLoginHandle()
    {
        $code = Input::get('code');
        if (!$code)
            return redirect('\login')->flash()->error('Cannot Login with Facebook');
        else {
            $user = Socialite::driver('facebook')->user();
            $facebookUser = null;
            $userCheck = User::where('email', '=', $user->email)->first();
            if (!empty($userCheck)) {
                $facebookUser = $userCheck;
            }else{
                $name = explode(' ', $user->name);
                $facebookUser= User::create([
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'username'=>$user->nickname,
                    'email' => $user->email,
                    'password' => null,
                    'is_maintainer'=>false,

                ]);

            }
            $this->auth->login($facebookUser, true);

            return redirect()->intended($this->redirectPath());
        }
    }





}
