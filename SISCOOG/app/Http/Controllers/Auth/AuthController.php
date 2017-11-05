<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $guard = 'user';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function showLoginForm(){

        if(view()->exists('auth.authenticate')){
            return view('auth.authenticate');
        }
        return view('auth.login');
    }

    public function login (Request $request){

        $validator = validator($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {

             return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        if (auth()->guard('user')->attempt($credentials)) {
            return redirect ('/home');
        }
        else {
            return redirect ('/login')
                    ->withErrors(['Errors' => 'Login Invalido'])
                    ->withInput();
        }

    }

    
    public function showRegistrationForm(){

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function register(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nascimento' => $request->nascimento,
            'sexo' => $request->sexo,
            'ocupation'=> $request->ocupation,
        ]);
        $_POST['primeiro'] = 'sim';
        return redirect ('/home');;
    }


    
}
