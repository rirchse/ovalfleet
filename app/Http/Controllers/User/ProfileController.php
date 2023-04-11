<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Image;
use Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = Auth::user()->id;
        $profile = User::find($id);
        return view('users.edit_profile')->withProfile($profile);        
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
        $user_id = Auth::user()->id;

        //validate the data        
        $this->validate($request, array(

            'first_name'    => 'required|max:50',
            'middle_name'   => 'max:50',
            'last_name'     => 'required|max:50',
            'contact'       => 'required|min:10|max:18',
            'address'       => 'max:255',
            'city'          => 'max:50',
            'state'         => 'max:50',
            'zip_code'      => 'max:50',
            'vat_id'        => 'max:100',
            'image'         => 'image',
            'vat_image'     => 'image|max:2000'

        ));

        //save the data to the database
        $update = User::find($user_id);
        $update->first_name   = ucfirst(strtolower($request->input('first_name')));
        $update->last_name    = ucfirst(strtolower($request->input('last_name')));
        $update->middle_name  = $request->input('middle_name');
        $update->contact      = $request->input('contact');
        $update->address      = $request->input('address');
        $update->city         = $request->input('city');
        $update->state        = $request->input('state');
        $update->zip_code     = $request->input('zip_code');
        $update->vat_id       = $request->input('vat_id');
        $update->country      = $request->input('country');
        $update->updated_by   = $user_id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        //vat scan copy//
        if($request->hasFile('vat_image')){
            $image = $request->file('vat_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/vat_image/' . $filename);
            Image::make($image)->save($location);

            $update->vat_image = $filename;
        }

        $update->save();

        //set flash data with success message
        Session::flash('success', 'Profile successfully updated.');

        //redirect with flash data to posts.show
        return redirect('/profile/edit');
    }

    public function changePassword()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        return view('users.change_my_password')->withProfile($user);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        //validate the data        
        $this->validate($request, array(
            'current_password' => 'required|min:8|max:32',
            'password'         => 'required|min:8|max:32|confirmed'
        ));

        function passverify($curr, $dbpass){
            return password_verify($curr, $dbpass);
        }

        if(passverify($request->current_password, $user->password) === false){

            Session::flash('error', 'You entered an incorrect password.');
            //redirect with flash data to posts.show
            return redirect('/change_my_password');

        } else if(passverify($request->password, $user->password) === true) {

            Session::flash('error', 'Do not use your current password as your new password.');
            //redirect with flash data to posts.show
            return redirect('/change_my_password');
        } else {

            //save the data to the database
            $update = User::find($user->id);
            $update->password     = bcrypt($request->input('password'));
            $update->updated_by   = $user->id;
            $update->save();

            //set flash data with success message
            Session::flash('success', 'Password successfully updated.');
        }

        //redirect with flash data to posts.show
        return redirect('/change_my_password');
    }
}
