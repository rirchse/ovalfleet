<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use Auth;
use Image;
use Session;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $user = User::find($user_id);
        return view('admins.profile')->withUser($user);
    }

    public function changePassword()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $user = Admin::find($user_id);
        return view('admins.edit_my_password')->withProfile($user);
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        //validate the data        
        $this->validate($request, array(

            'current_password' => 'required|min:8|max:32',
            'password'         => 'required|min:8|max:32|confirmed'

        ));

        function passverify($curr, $dbpass){
            return password_verify($curr, $dbpass);
        }

        if(passverify($request->current_password, $admin->password) === false){

            Session::flash('error', 'You entered an incorrect password.');
            //redirect with flash data to posts.show
            return redirect('/admin/change_my_password');

        } else if(passverify($request->password, $admin->password) === true) {

            Session::flash('error', 'Do not use your current password as your new password.');
            //redirect with flash data to posts.show
            return redirect('/admin/change_my_password');
        } else {

            //save the data to the database
            $update = Admin::find($admin->id);
            $update->password     = bcrypt($request->input('password'));
            $update->updated_by   = $admin->id;
            $update->updator_role = 'admin';
            $update->save();

            //set flash data with success message
            Session::flash('success', 'Password successfully updated.');
        }

        //redirect with flash data to posts.show
        return redirect('/admin/change_my_password');
    }


    public function index()
    {
        $user_id = Auth::guard('admin')->user()->id;
        // Get all users from database
        $users = Admin::orderBy('id', 'DESC')->where('id', '!=', $user_id)->get();
        return view('admins.view_all_admins')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create_new_admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::guard('admin')->user()->id;
        //validate the data
        $this->validate($request, array(

            'user_role'     => 'required|min:2|max:32',
            'user_role_name'=> 'required|max:32',
            'first_name'    => 'required|min:2|max:32',
            'last_name'     => 'required|min:2|max:32',
            'email'         => 'required|unique:users|email|max:50',
            'password'      => 'required|min:8|max:32',
            'contact'       => 'max:18',
            'dob'           => 'max:10',
            'job_title'     => 'max:32',
            'profile_image' => 'image'

        ));

        //store in the database
        $createAdmin = new Admin;
        $createAdmin->user_role      = $request->user_role;
        $createAdmin->user_role_name = $request->user_role_name;
        $createAdmin->first_name     = $request->first_name;
        $createAdmin->last_name      = $request->last_name;
        $createAdmin->email          = $request->email;
        $createAdmin->password       = bcrypt($request->password);
        $createAdmin->contact        = $request->contact;
        $createAdmin->dob            = $request->dob;
        $createAdmin->job_title      = $request->job_title;
        $createAdmin->created_by     = $user_id;

        //save image//
        if($request->hasFile('profile_image')){
            $image    = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);
            $createAdmin->image = $filename;
        }

        $createAdmin->save();

        //session flashing
        Session::flash('success', 'New account successfully created!');

        //return to the show page
        return redirect('/admin/account');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Grab user data by id
        $user = User::find($id);
        return view('admins.user_profile')->withProfile($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $user    = Admin::find($user_id);
        return view('admins.edit_profile')->withProfile($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::guard('admin')->user()->id;
        //validate the data        
        $this->validate($request, array(

            'user_role'     => 'required|min:2|max:32',
            'first_name'    => 'required|min:2|max:32',
            'last_name'     => 'required|min:2|max:32',
            'contact'       => 'max:18',
            'dob'           => 'max:10',
            'job_title'     => 'max:32',
            'profile_image' => 'image'

        ));

        //save the data to the database
        $update = Admin::find($id);
        $update->user_role    = $request->input('user_role');
        $update->first_name   = $request->input('first_name');
        $update->last_name    = $request->input('last_name');
        $update->contact      = $request->input('contact');
        $update->dob          = $request->input('dob');
        $update->job_title    = $request->input('job_title');
        $update->updated_by   = $user_id;
        $update->updator_role = 'admin';

        //save image//
        if($request->hasFile('profile_image')){
            $image    = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('images/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        $update->save();

        //set flash data with success message
        Session::flash('success', 'User information successfully updated.');

        //redirect with flash data
        return redirect('/admin/admin/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();

        Session::flash('success', 'Account successfully deleted!');

        return redirect('/admin/show_admins');
    }
}