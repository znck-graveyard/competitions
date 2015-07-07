<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Input;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class AuthController extends Controller
{

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

    use AuthenticatesAndRegistersUsers {
        postLogin as origPostLogin;
    }

    protected $redirectPath = '/';
    protected $loginPath    = '/login';
    protected $auth;
    protected $user;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param \App\User                         $user
     *
     * @internal param \Illuminate\Contracts\Auth\Registrar $registrar
     */
    public function __construct(Guard $auth, User $user)
    {
        $this->auth = $auth;
        $this->user = $user;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'username'   => 'required|max:255|unique:users',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
        ]);
    }

    public function facebookLogin()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function facebookLoginHandle()
    {
        $code = Input::get('code');

        if (!$code) {
            flash()->error('Cannot login with Facebook.');

            return redirect('/auth/login');
        }

        $user = Socialite::driver('facebook')->user();
        $facebookUser = User::where('email', '=', $user->email)->first();

        if (empty($facebookUser)) {
            $facebookUser = User::create([
                'first_name' => $user->offsetGet('first_name'),
                'last_name'  => $user->offsetGet('last_name'),
                'email'      => $user->email,
            ]);

            $facebookUser->attributes()->create(['key' => 'profile_pic', 'value' => $user->avatar]);
        }
        $this->auth->login($facebookUser, true);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        $email = $request->get($this->loginUsername());

        $credentials = $request->only('password');
        if (str_contains($email, '@')) {
            $credentials['email'] = $email;
        } else {
            $credentials['username'] = $email;
        }

        return $credentials;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required|min:1',
            'password'             => 'required',
        ]);

        return $this->origPostLogin($request);
    }
}
