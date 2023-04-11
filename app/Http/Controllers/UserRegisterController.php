<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Image;
use Session;

class UserRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('homes.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(

            'first_name'    => 'required|min:2|max:32',
            'last_name'     => 'required|min:2|max:32',
            'email'         => 'required|unique:users|email|max:50',
            'password'      => 'required|min:8|max:32',
            'contact'       => 'required|min:10|max:18',
            'dob'           => 'required|min:10|max:10',
            'job_title'     => 'required|min:2|max:32',
            'facebook'      => 'sometimes|url',
            'nid'           => 'required|min:17',
            'profile_image' => 'image'

        ));

        //store in the database
        $register = new User;
        $register->first_name = $request->first_name;
        $register->last_name  = $request->last_name;
        $register->email      = $request->email;
        $register->password   = bcrypt($request->password);
        $register->contact    = $request->contact;
        $register->dob        = $request->dob;
        $register->job_title  = $request->job_title;
        $register->facebook   = $request->facebook;
        $register->nid        = $request->nid;

        //save image//
        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('images/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $register->image = $filename;
        }
        $register->save();

        //session flashing
        Session::flash('success', 'Sign up successfully completed!');

        //return to the show page
        return redirect('/register');
    }
}