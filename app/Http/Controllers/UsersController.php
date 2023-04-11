<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;
use Session;

class UsersController extends Controller
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
        // Get all users from database
        $users = User::all();
        return view('admins.users')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create_new_user');
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
        $create_user = new User;
        $create_user->first_name   = $request->first_name;
        $create_user->last_name    = $request->last_name;
        $create_user->email        = $request->email;
        $create_user->password     = bcrypt($request->password);
        $create_user->contact      = $request->contact;
        $create_user->dob          = $request->dob;
        $create_user->job_title    = $request->job_title;
        $create_user->created_by   = $user_id;
        $create_user->creator_role = 'admin';
        $create_user->status       = 1;

        //save image//
        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('images/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $create_user->image = $filename;
        }
        $create_user->save();

        //session flashing
        Session::flash('success', 'User successfully created!');

        //return to the show page
        return redirect('/admin/create_new_user');
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
}