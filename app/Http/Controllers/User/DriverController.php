<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Session;
use Image;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->where('user_role', 'Driver')->paginate(20);
        return view('users.view_driver_accounts')->withDrivers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create_driver_account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $creator = Auth::user();
        //validate the data        
        $this->validate($request, array(

            'first_name'    => 'required|max:50',
            'middle_name'   => 'required|max:50',
            'last_name'     => 'required|max:50',
            'email'         => 'required|max:50',
            'contact'       => 'required|min:10|max:18',
            'address'       => 'max:255',
            'state'         => 'max:50',
            'zip_code'      => 'max:50',
            'image'         => 'image'

        ));

        //store in the database
        $create = new User;
        $create->first_name   = $request->first_name;
        $create->last_name    = $request->last_name;
        $create->middle_name  = $request->middle_name;
        $create->email        = $request->email;
        $create->password     = bcrypt($request->contact);
        $create->contact      = $request->contact;
        $create->address      = $request->address;
        $create->state        = $request->state;
        $create->zip_code     = $request->zip_code;
        $create->country      = $request->country;
        $create->user_role    = 'Driver';
        $create->created_by   = $creator->id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $create->image = $filename;
        }

        $create->save();

        //session flashing
        Session::flash('success', 'Driver account successfully created!');
        
        //return to the show page
        return redirect('/create_driver_account');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = User::find($id);
        return view('users.edit_driver_account')->withDriver($driver);
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
        $creator = Auth::user();
        //validate the data        
        $this->validate($request, array(

            'first_name'    => 'required|max:50',
            'middle_name'   => 'required|max:50',
            'last_name'     => 'required|max:50',
            'email'         => 'required|max:50',
            'contact'       => 'required|min:10|max:18',
            'address'       => 'max:255',
            'state'         => 'max:50',
            'zip_code'      => 'max:50',
            'image'         => 'image'

        ));

        //store in the database
        $update = User::find($id);
        $update->first_name   = ucfirst(strtolower($request->input('first_name')));
        $update->last_name    = ucfirst(strtolower($request->input('last_name')));
        $update->middle_name  = $request->input('middle_name');
        $update->contact      = $request->input('contact');
        $update->address      = $request->input('address');
        $update->state        = $request->input('state');
        $update->zip_code     = $request->input('zip_code');
        $update->country      = $request->input('country');
        $update->updated_by   = $creator->id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        $update->save();

        //session flashing
        Session::flash('success', 'Driver account successfully updated!');
        
        //return to the show page
        return redirect('/driver/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find item and delete
        User::find($id)->delete();

        //flash the message
        Session::flash('success', 'Driver account has been successfully deleted.');

        //return to the index page
        return redirect('/view_driver_accounts');
    }
}