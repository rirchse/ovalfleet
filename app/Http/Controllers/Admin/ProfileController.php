<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use Auth;
use Image;
use Session;
use File;

class ProfileController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $profile = Admin::find($user_id);
        return view('admins.profile')->withProfile($profile);
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
        $user = Admin::find($user_id);
        return view('admins.edit_profile')->withProfile($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = Auth::guard('admin')->user()->id;
        //validate the data        
        $this->validate($request, array(

            'first_name'    => 'required|max:50',
            'middle_name'   => 'required|max:50',
            'last_name'     => 'required|max:50',
            'contact'       => 'required|min:10|max:18',
            'job_title'     => 'max:50',
            'image'         => 'image'
        ));

        //get existing profile image
        $exist_image = Admin::find($user_id)->image;

        //save the data to the database
        $update = Admin::find($user_id);
        $update->first_name   = $request->input('first_name');
        $update->last_name    = $request->input('last_name');
        $update->middle_name  = $request->input('middle_name');
        $update->contact      = $request->input('contact');
        $update->job_title    = $request->input('job_title');
        $update->updated_by   = $user_id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        $update->save();

        //delete exists image
        $ex_img = 'images/profile/'.$exist_image;
        if(File::exists($ex_img)){
            File::delete($ex_img);
        }

        //set flash data with success message
        Session::flash('success', 'Information successfully updated.');

        //redirect with flash data to posts.show
        return redirect('/admin/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}