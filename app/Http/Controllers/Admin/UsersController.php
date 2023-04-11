<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use App\Relation;
use App\ShipmentExpense;
use App\Referral;
use App\Shipment;
use App\Vehicle;
use App\User;
use App\Admin;
use App\Mypackage;
use App\Payment;
use Auth;
use Image;
use Session;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /* user subscribe by admin */
    // public function subscribe($id)
    // {
    //     $user = User::find($id);
    //     $packages = Package::where('duration', 'year')->get();
    //     return view('admins.create_user_subscribe', compact('user', 'packages'));
        
    // }

    // public function subscribeStore(Request $request)
    // {
    //     $this->validate($request, [
    //         'user_id' => 'required',
    //         'plan_id' => 'required'
    //         ]);
    //     $plan = Package::find($request->plan_id);
    //     //pacakge create
    //     $create = New Mypackage;
    //     $create->user_id          = $request->user_id;
    //     $create->package_id       = $request->plan_id;
    //     $create->package_price    = $plan->package_price;
    //     $create->amount_payable   = $plan->package_price;
    //     $create->previous_package = 0;
    //     $create->actual_duration  = 365;
    //     $create->expires_on       = date('Y-m-d', strtotime('+1 year'));
    //     $create->buy_date         = date('Y-m-d');
    //     $create->payment_status   = 'Paid';
    //     $create->status           = 1;
    //     $create->created_by       = 0;
    //     $create->save();

    //     Session::flash('success', 'New subscription created.');
    //     return redirect('/admin/view_services/all');
    // }

    // public function login($id)
    // {
    //     Auth::loginUsingId($id);
    //     return redirect('/home');
    // }

    static function adminLoginTo()
    {
        if(!empty(Session::get('_admuser'))){
            $admuser = Session::get('_admuser');

            if(Auth::guard('admin')->check() == true){

                if(Auth::loginUsingId($admuser['userId'])){
                    Session::forget('_admuser');
                    return redirect('/home');
                }
            }
        }

        return redirect('admin/view_users/active');        
    }

    public function login($id)
    {
        $admin = Auth::guard('admin')->user()->id;
        $admuser = [];
        $user = User::find($id);
        if($user->status == 1){
            $admuser = ['adminId' => $admin, 'userId' => $id];
        }else{
            return redirect('/admin/view_users/all');
        }

        Session::put('_admuser', $admuser);
        return redirect('/admin/admin_loginto');
    }


    /* below method for resend email verification to the unverified account holder */
    public function reverify($id)
    {
        //token generator
        $token = md5(rand(789, 3));

        $user = User::find($id);
        $user->remember_token = $token;
        $user->save();

        $data = array(
            'user_id' => $user->id,
            'name'    => $user->first_name.' '.$user->last_name,
            'token'   => $token,
            'email'   => $user->email,
            'host'    => SourceController::host()
        );

        Mail::send('emails.resend_user_email_verify', $data, function($message) use ($data){
            $message->from('do_not_reply@ovalfleet.com');
            $message->to($data['email']);
            $message->subject('Email Verification || OvalFleet.com');
        });

        //session flashing
        Session::flash('success', 'Verification request mail successfully sent to the user.');
        
        //return to the show page
        return redirect('/admin/view_users/'.Session::get('_types'));
    }

    public function index($types)
    {
        Session::put('_types', $types);
        $users = [];
        if($types == 'all'){
            $users = User::orderBy('id', 'DESC')->paginate(20);
            return view('admins.view_users')->withUsers($users);
        }elseif($types == 'active'){
            $users = User::orderBy('id', 'DESC')->where('status', 1)->paginate(20);
            return view('admins.view_active_users')->withUsers($users);
        }elseif($types == 'inactive'){
            $users = User::orderBy('id', 'DESC')->where('status', 3)->paginate(20);
            return view('admins.view_inactive_users')->withUsers($users);
        }
    }

    public function getAdmins()
    {
        $users = Admin::all();
        return view('admins.view_all_admins')->withUsers($users);
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
            'password'      => 'required|min:8|max:32|confirmed',
            'contact'       => 'max:18',
            'dob'           => 'max:10',
            'job_title'     => 'max:32',
            'user_type'     => 'max:32',
            'profile_image' => 'image'

        ));

        if($request->user_type == 'user') {

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
                $image    = $request->file('profile_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = ('images/profile/' . $filename);
                Image::make($image)->resize(600, 600)->save($location);

                $create_user->image = $filename;
            }
            $create_user->save();            


        } else if ($request->user_type == 'admin') {
            //store in the database
            $createAdmin = new Admin;
            $createAdmin->first_name   = $request->first_name;
            $createAdmin->last_name    = $request->last_name;
            $createAdmin->email        = $request->email;
            $createAdmin->password     = bcrypt($request->password);
            $createAdmin->contact      = $request->contact;
            $createAdmin->dob          = $request->dob;
            $createAdmin->job_title    = $request->job_title;
            $createAdmin->type         = 'admin';
            $createAdmin->created_by   = $user_id;
            $createAdmin->creator_role = 'admin';

            //save image//
            if($request->hasFile('profile_image')){
                $image    = $request->file('profile_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = ('images/profile/' . $filename);
                Image::make($image)->resize(600, 600)->save($location);

                $createAdmin->image = $filename;
            }
            $createAdmin->save();
        }        

        //session flashing
        Session::flash('success', 'New '.$request->user_type.' successfully created!');

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
        return view('admins.read_user')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admins.edit_user_account')->withUser($user);
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

            'first_name'    => 'required|max:50',
            'middle_name'   => 'max:50',
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
        $update->first_name   = $request->input('first_name');
        $update->last_name    = $request->input('last_name');
        $update->middle_name  = $request->input('middle_name');
        $update->contact      = $request->input('contact');
        $update->address      = $request->input('address');
        $update->state        = $request->input('state');
        $update->zip_code     = $request->input('zip_code');
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

        $update->save();

        //set flash data with success message
        Session::flash('success', 'User information successfully updated.');

        //redirect with flash data to posts.show
        return redirect('/admin/user/'.$id.'/edit');
    }

    public function permitAdmin(Request $request, $id)
    {
        $user_id = Auth::guard('admin')->user()->id;
        $user = User::find($id);

        $admin = new Admin;
        $admin->first_name  = $user->first_name;
        $admin->last_name   = $user->last_name;
        $admin->email       = $user->email;
        $admin->contact     = $user->contact;
        $admin->type        = 'admin';
        $admin->password    = $user->password;
        $admin->dob         = $user->dob;
        $admin->job_title   = $user->job_title;
        $admin->image       = $user->image;
        $admin->created_by  = $user_id;
        $admin->creator_role = 'admin';

        $admin->save();

        //set flash data with success message
        Session::flash('success', 'User permitted as admin.');

        //redirect with flash data to posts.show
        return redirect('/admin/user/'.$id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the container
        $user = User::find($id);

        //delete the container
        $user->delete();

        //flash the message
        Session::flash('success', 'User has been successfully deleted.');

        //return to the index page
        return redirect('/admin/view_users'.Session::get('_types'));
    }

    public function delete($id)
    {
        // $user = User::find($id)->delete();
        $update = User::find($id);
        $update->remind_status = $update->status;
        $update->status = 3;
        $update->save();
        
        //flash the message
        Session::flash('success', 'Account successfully deleted. You have 15 days to restore the account before it is permanently removed from the system.');

        //return to the index page
        return redirect('/admin/view_users/'.Session::get('_types'));
    }

    public function restore($id)
    {
        $update = User::find($id);
        $update->status = $update->remind_status;
        $update->save();

        //flash the message
        Session::flash('success', 'Account successfully restored.');

        //return to the index page
        return redirect('/admin/view_users/'.Session::get('_types'));
    }

    public function permDelUser($id)
    {
        $user = User::find($id);

        $relations = Relation::where('owner_id', $id)->get();
        if(count($relations) > 0){
            foreach($relations as $relation){
                $relation->delete();
            }
        }

        $shipments = Shipment::where('user_id', $id)->get();
        if(count($shipments) > 0){
            foreach($shipments as $shipment){
                $shipment->delete();
            }
        }

        $vehicles = Vehicle::where('user_id', $id)->get();
        if(count($vehicles) > 0){
            foreach($vehicles as $vehicle){
                $vehicle->delete();
            }
        }

        $referrals = Referral::where('refer_by', $id)->get();
        if(count($referrals) > 0){
            foreach($referrals as $referral){
                $referral->delete();
            }
        }

        $shipexpns = ShipmentExpense::where('driver_id', $id)->get();
        if(count($shipexpns) > 0){
            foreach($shipexpns as $shipexpn){
                $shipexpn->delete();
            }
        }

        $subscriptions = Mypackage::where('user_id', $id)->get();
        if(count($subscriptions) > 0){
            foreach($subscriptions as $subscribe){
                $subscribe->delete();
            }
        }

        $payments = Payment::where('user_id', $id)->get();
        if(count($payments) > 0){
            foreach($payments as $payment){
                $payment->delete();
            }
        }

        $user->delete();

        //flash the message
        Session::flash('success', 'User has been permanently removed from the system. Email: '.$user->email);

        //return to the index page
        return redirect('/admin/view_users/'.Session::get('_types'));
    }



    /* -------------------- reports dispatcher and driver ----------------*/
    public function dispatcherReports()
    {
        $dispatchers = User::where('user_role', 'dispatcher')->paginate(20);
        $shipments = Shipment::where('status', 1)->get();

        return view('admins.reports_dispatchers')->withDispatchers($dispatchers)->withShipments($shipments);
    }

    public function driverReports()
    {
        $drivers = User::where('user_role', 'driver')->paginate(20);
        $shipments = Shipment::where('status', 1)->get();

        return view('admins.reports_drivers')->withDrivers($drivers)->withShipments($shipments);
    }
}