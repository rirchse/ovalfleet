<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Notify;
use App\Users;
use App\User;
use Session;
use DB;
use Image;

class DispatchController extends Controller
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
        $dispatch = User::orderBy('id', 'DESC')->where('user_role', 'Dispatch')->get();
        return view('users.view_dispatch_accounts')->withDispatches($dispatch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create_dispatch_account');
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
        $create = new Users;
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
        $create->user_role    = 'Dispatch';
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
        Session::flash('success', 'New dispatch account successfully created!');
        
        //return to the show page
        return redirect('/create_dispatch_account');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $worder = Workorder::find($id);
        $bols = Billoflading::where('work_order_id', $id)->get();
        $tickets = Ticket::where('work_order_id', $id)->get();
        return view('users.work_order_detail')->withWorder($worder)->withBols($bols)->withTickets($tickets);
    }

    public function details()
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
        $dispatch = Users::find($id);
        return view('users.edit_dispatch_account')->withDispatch($dispatch);
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
        $update = Users::find($id);
        $update->first_name   = $request->input('first_name');
        $update->last_name    = $request->input('last_name');
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
        Session::flash('success', 'Dispatch account successfully updated!');
        
        //return to the show page
        return redirect('/dispatch/'.$id.'/edit');
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
        Users::find($id)->delete();

        //flash the message
        Session::flash('success', 'The dispatch account was successfully deleted.');

        //return to the index page
        return redirect('/view_dispatch_accounts');
        
    }
}
