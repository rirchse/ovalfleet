<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class AdminLoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest:admin', ['except' => ['logout']]);
	}

    public function showLoginForm () 
    {
    	return view('admins.login');
    }

    public function login(Request $request) {
    	
    	// validate the form data
    	$this->validate($request, [
    		'email'    => 'required|email',
    		'password' => 'required|min:6',
            'g-recaptcha-response' => 'recaptcha'
    		]);

    	// attempt to the log the user in
    	if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    		// if successful, then redirect to their intended location
    		return redirect()->intended(route('admin.dashboard'));
    	} else {
            Session::flash('error', 'Login credentials do not match!');
            return redirect('/admin/login');
        }

    	// if unsuccessful, then redirect back to the login with form data
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
