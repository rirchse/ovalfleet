<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;

class UserLoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest', ['except' => ['logout']]);
	}
    
    public function getLogin () 
    {
    	return view('homes.login');
    }

    public function login(Request $request) 
    {
    	
    	// validate the form data
    	$this->validate($request, [
    		'email'    => 'required|email',
    		'password' => 'required|min:8',
            'g-recaptcha-response' => 'recaptcha'
    		]);

    	// attempt to the log the user in
        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            Session::flash('error', 'You do not have an account with OvalFleet. Please Sign Up.');
            return redirect('/login');
        }else if($user->status != 1){
            Session::flash('error', 'Account is not verified. Please check your email and verify your account.');
            return redirect('/login');
        }else if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    		// if successful, then redirect to their intended location
            return redirect()->intended('/home');
    	} else {
            Session::flash('error', 'Login credentials do not match!');
            return redirect('/login');
        }

    	// if unsuccessful, then redirect back to the login with form data
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/');
    }

}
