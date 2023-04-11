<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Image;
use Session;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = Auth::user()->id;
        $profile = User::find($id);
        return view('users.profile')->withProfile($profile);
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        //validate the data
        
        $this->validate($request, array(

            'first_name'    => 'required|min:2|max:32',
            'last_name'     => 'required|min:2|max:32',
            'contact'       => 'required|min:10|max:18',
            'dob'           => 'required|min:10|max:10',
            'facebook'      => 'sometimes|url',
            'profile_image' => 'image'

        ));

        //save the data to the database
        $update = User::find($id);
        $update->first_name = $request->input('first_name');
        $update->last_name  = $request->input('last_name');
        $update->password   = $request->input('password');
        $update->contact    = $request->input('contact');
        $update->dob        = $request->input('dob');
        $update->job_title  = $request->input('job_title');
        $update->facebook   = $request->input('facebook');

        //save image//
        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('images/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        $update->save();

        //set flash data with success message
        Session::flash('success', 'Profile successfully updated.');

        //redirect with flash data to posts.show
        return redirect('/profile');
    }
}