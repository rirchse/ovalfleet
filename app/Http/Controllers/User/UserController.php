<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\Relation;
use App\Shipment;
use App\User;
use App\Referral;
use App\Mypackage;
use Session;
use Image;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    static function accountExpire()
    {
        $user = Auth::user();
        /* account expire calculation */
        if($user->user_role == 'Fleet Owner'){
            $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
            if(!empty($mypackage)){
                $remaining = (strtotime(date('Y-m-d')) - strtotime($mypackage->expires_on))/24/3600;
                if($mypackage->status != 1 || $remaining > 0){
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }

    public function resendEmailVerify($usertype, $id)
    {
        //token generator
        $token = md5(rand(789, 3));

        $user = User::find($id);
        $user->remember_token = $token;
        $user->save();

        $data = array(
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
        return redirect('/my/'.$usertype.'s');
    }

    /* Associated with Fleet Owners start */

    public function assocUsers($id, $usertype){
        $drivers = Relation::leftJoin('users', 'users.id', 'relations.user_id')
        ->where('relations.owner_id', $id)
        ->where('users.user_role', ucwords($usertype))
        ->paginate(20);
        return view('users.view_associated_other_users')->withOtherusers($drivers)->withUserrole($usertype);
    }

    public function readAssocUser($usertype, $user_id)
    {
        $user = User::leftJoin('relations', 'users.id', 'relations.user_id')
        ->select('users.*', 'relations.owner_id')
        ->where('users.id', $user_id)->first();
        return view('users.read_associated_user')->withUser($user);
    }
    /* Associated with Fleet Owners end */

    public function findUser($usertype)
    {
        Session::put('usertype', $usertype);
        Session::forget('_for');
        return view('users.search_user');
    }

    public function findUserFor($usertype, $for)
    {
        Session::put('usertype', $usertype);
        Session::put('_for', $for);
        return view('users.search_user');
    }
    public function find_user(Request $request)
    {
        $this->validate($request, [
            'account_number' => 'max:255',
            'email'          => 'max:50',
            'contact'        => 'max:11'
            ]);

        $usertype = Session::get('usertype');
        $user = [];

        if(!empty($request->account_number)){
            $user = User::where('user_role', ucwords($usertype))->where('account_number', $request->account_number)->first();
        } else if(!empty($request->email)){
            $user = User::where('user_role', ucwords($usertype))->where('email', $request->email)->first();
        } else if(!empty($request->contact)){
            $user = User::where('user_role', ucwords($usertype))->where('contact', $request->contact)->first();
        }else{
            Session::flash('error', 'Please input relevant information in any one of the search fields.');
            return redirect('/search/'.$usertype);
        }

        if(empty($user)) {
            Session::flash('error', ucwords($usertype).' account not found. <a href="/create_user/'.$usertype.'">Click here</a> to Create a '.ucwords($usertype).' Account.');
            return redirect('/search/'.$usertype);
        }

        if(!empty($user)){
            return redirect('/search/'.$usertype.'/'.$user->id.'/details');
        }
    }

    public function user_search_result($usertype, $id)
    {
        $user = User::find($id);
        // Session::forget('usertype');
        if(ucwords($usertype) != $user->user_role){
            Session::flash('error', ucwords($usertype).' account not found. <a href="/create_user/'.$usertype.'">Click here</a> to Create a '.ucwords($usertype).' Account.');
            return redirect('/search/'.$usertype);
        }
        return view('users.read_search_user')->withUser($user);
    }

    public function createUserShipment($usertype, $section)
    {
        Session::put('usertype', $usertype);
        Session::put('section', $section);
        return view('users.create_user_account')->withUsertype($usertype)->withSection($section);
    }
    public function createUser($usertype)
    {
        /* accout expire check and redirect to */
        if(UserController::accountExpire() == true){
            return redirect('/select_package');
        }
        
        if(Session::get('section')){
            Session::forget('section');
        }
        Session::put('usertype', $usertype);
        return view('users.create_user_account')->withUsertype($usertype);
    }    

    public function index()
    {
        $user = Auth::user();
        $users = User::where('created_by', $user->id)->orderBy('id', 'DESC')->paginate(20);
        return view('users.view_user_accounts')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function resendInvitation($id)
    {
        //token generator
        $token = md5(rand(789, 3));

        $user = Auth::user();

        $update = User::find($user->id);
        $update->remember_token = $token;
        $update->save();

        $referto = Referral::find($id);
        $referto->sending_count = $referto->sending_count+1;
        $referto->save();

        /* create data for email */
            $data = array(
                'name'         => $user->first_name.' '.$user->last_name,
                'email'        => $referto->email,
                'user_email'   => $user->email,
                'details'      => $referto->notes,
                'account_type' => $user->user_role,
                'host'         => SourceController::host()
            );

            /* sent invitation email function */
            Mail::send('emails.send_invitation', $data, function($message) use ($data){
                $message->from('do_not_reply@ovalfleet.com');
                $message->to($data['email']);
                $message->subject('Invitation to join OvalFleet.com');
            });

            Session::flash('success', 'Your invitation mail has been sent successfully.');
            return redirect('/create_invitation');
    }


    public function create()
    {
        return view('users.create_user_account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logged_user = Auth::user();
        //validate the data        
        $this->validate($request, array(

            'first_name'     => 'required|max:50',
            'middle_name'    => 'max:50',
            'last_name'      => 'Required|max:50',
            'email'          => 'required|max:50',
            'contact'        => 'required|max:18',
            'password'       => 'required|confirmed|min:8|max:32',
            'account_type'   => 'required|max:50',
            'driver_license' => 'max:50',
            'organization'   => 'max:100',
            'address'        => 'max:255',
            'state'          => 'max:50',
            'zip_code'       => 'max:50',
            'image'          => 'image'
        ));

        //token generator
        $token = md5(710);
        //enduser checking
        $enduser = User::where('email', $request->email)->first();
        if(!empty($enduser)){
            //session flashing
            Session::flash('error', 'Account already exists.');
            
            //return to the show page
            return redirect('/create_user/'.strtolower($request->account_type));
        }else{
            //store in the database
            $user = new User;
            $user->first_name      = $request->first_name;
            $user->middle_name     = $request->middle_name;
            $user->last_name       = $request->last_name;
            $user->email           = $request->email;
            $user->contact         = $request->contact;
            $user->password        = bcrypt($request->password);
            $user->address         = $request->address;
            $user->state           = $request->state;
            $user->zip_code        = $request->zip_code;
            $user->country         = $request->country;
            $user->remember_token  = $token;
            $user->user_role       = $request->account_type;
            $user->driver_license  = $request->driver_license;
            $user->organization    = $request->organization;
            $user->user_role       = $request->account_type;
            $user->created_by      = $logged_user->id;

            //save image//
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = ('img/profile/' . $filename);
                Image::make($image)->resize(600, 600)->save($location);

                $user->image = $filename;
            }

            $user->save();

            $lastuser = User::orderBy('id', 'DESC')->first();

            //connect last created user to account
            $create = New Relation;
            $create->owner_id = $logged_user->id;
            $create->user_id  = $lastuser->id;
            $create->save();

            $create = New Relation;
            $create->owner_id = $lastuser->id;
            $create->user_id  = $logged_user->id;
            $create->save();

            //create data for email template
            $data = array(
                'user_id' => $lastuser->id,
                'name'    => $user->first_name.' '.$user->last_name,
                'token'   => $token,
                'email'   => $user->email,
                'details' => $request->message,
                'host'    => SourceController::host()
            );

            Mail::send('emails.user_email_verify', $data, function($message) use ($data){
                $message->from('do_not_reply@ovalfleet.com');
                $message->to($data['email']);
                $message->subject('Email Verification || OvalFleet.com');
            });

            //session flashing
            Session::flash('success', ucfirst(Session::get('usertype')).' successfully added! Recipient has received an email to complete the verification. By signing up with OvalFleet, the user will receive information related to service launch updates, important notifications, new features and upcoming OvalFleet Events.');
            
            if(!empty(Session::get('section'))){
                return redirect('/create_shipment');
                Session::forget('section');
            }else{
                //return to the show page
                return redirect('/my/'.Session::get('usertype').'/'.$lastuser->id.'/details');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.read_user')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dispatch = User::find($id);
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
        Session::flash('success', 'Dispatcher account successfully updated!');
        
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
        User::find($id)->delete();

        //flash the message
        Session::flash('success', 'Dispatcher account has been successfully deleted.');

        //return to the index page
        return redirect('/view_dispatch_accounts');
        
    }

    public function userAddToAccount($usertype, $id)
    {
        $owner = Auth::user(); // logged in user
        $user = User::find($id);

        if($owner->user_role == 'Fleet Owner'){

        if(UserController::accountExpire() == true){
            return redirect('/select_package');
        }

        $mypackage = Mypackage::leftJoin('packages', 'packages.id', 'mypackages.user_id')->where('mypackages.user_id', $owner->id)->orderBy('mypackages.id', 'DESC')->first();
        function relationlimit($type){
            $relations = Relation::leftJoin('users', 'users.id', 'relations.user_id')->where('users.user_role', $type)->where('relations.owner_id', $owner->id)->get();
            return count($relations);
        }
        if($usertype == 'Driver' && relationlimit('Driver') > $mypackage->max_driver || $usertype == 'Dispatcher' && relationlimit('Dispatcher') > $mypackage->max_dispatcher){
            Session::flash('success', 'You have limit over added to '.ucfirst($usertype).' Please upgrade your <a href="/select_package">Service Plan</a>.');
            return redirect('/search/'.$usertype.'/'.$id.'/details');
        }
    }
        

        if(!empty(Relation::where('owner_id', $owner->id)->where('user_id', $id)->first())) {
            
            if(Session::get('_for')){
                Session::flash('error', 'The '.ucfirst($usertype).' is already in your "My '.ucfirst($usertype).'s". Please select this '.ucfirst($usertype).' from the dropdown now.');
                return redirect('/create_shipment');
            }

            Session::flash('error', 'The '.ucfirst($usertype).' is already in your "My '.ucfirst($usertype).'s".');
            return redirect('/search/'.$usertype.'/'.$id.'/details');
        }else{

            $create = New Relation;
            $create->owner_id = $owner->id;
            $create->user_id  = $user->id;
            $create->save();

            $create = New Relation;
            $create->owner_id = $user->id;
            $create->user_id  = $owner->id;
            $create->save();

            if(Session::get('_for')){
                Session::flash('success', 'The '.ucfirst($usertype).' is successfully added to your "My '.ucfirst($usertype).'s". Please select this '.ucfirst($usertype).' from the dropdown now.');
                return redirect('/create_shipment');
            }

            Session::flash('success', 'The '.ucfirst($usertype).' is successfully added to your "My '.ucfirst($usertype).'s".');
            return redirect('/my/'.$usertype.'s');
        }

    }

    public function connectedUsers($usertype)
    {
        $users = [];
        $usertype = substr($usertype, 0, -1);
        $owner = Auth::user(); // logged in user
        if($owner->user_role == 'Dispatcher' && $usertype == 'Fleet Owner'){
            $users = Relation::leftJoin('users', 'relations.user_id', 'users.id')->where('relations.owner_id', $owner->id)->where('users.user_role', $usertype)->select('users.*')->paginate(20);

        }else{
            $users = Relation::leftJoin('users', 'relations.user_id', 'users.id')->where('relations.owner_id', $owner->id)->where('users.user_role', $usertype)->select('users.*')->paginate(20);
        }
        
        return view('users.view_user_relations')->withUsertype($usertype)->withUsers($users);
    }

    public function connectedUsersShow($usertype, $id)
    {
        $user = User::find($id);
        return view('users.read_user_relation')->withUsertype($usertype)->withUser($user);
    }

    public function connectedUserRemove($usertype, $id)
    {
        $owner = Auth::user(); // logged in user
        Relation::where('owner_id', $owner->id)->where('user_id', $id)->first()->delete();
        if(!empty(Relation::where('owner_id', $id)->where('user_id', $owner->id)->first())){
            Relation::where('owner_id', $id)->where('user_id', $owner->id)->first()->delete();
        }

        Session::flash('success', 'The '.ucfirst($usertype).' is successfully removed from your account.');
        return redirect('/my/'.$usertype.'s');
    }

    public function relationUsers()
    {
        $user = Auth::user();
        $users = Relation::leftJoin('users', 'users.id', 'relations.user_id')->where('relations.owner_id', $user->id)->select('users.*', 'relations.created_at as joined')->paginate(20);
        return view('users.view_relation_users')->withRelations($users);
    }

    /* -------------------- reports dispatcher and driver ----------------*/
    public function dispatcherReports()
    {
        //fleet owner access
        $user = Auth::user();
        $drivers = Relation::leftJoin('users', 'users.id', 'relations.user_id')->where('relations.owner_id', $user->id)->where('user_role', 'dispatcher')->get();
        // $shipments = Shipment::where('fleetowner_id', $user->id)->where('status', 1)->get();
        $shipments = Shipment::where('fleetowner_id', $user->id)->whereNotNull('dispatcher_id')->where('status', 2)->get();

        return view('users.reports_dispatchers')->withDispatchers($drivers)->withShipments($shipments);
    }

    public function driverReports()
    {
        //fleet owner access
        $user = Auth::user();
        $drivers = Relation::leftJoin('users', 'users.id', 'relations.user_id')->where('relations.owner_id', $user->id)->where('user_role', 'driver')->get();
        $shipments = Shipment::where('fleetowner_id', $user->id)->whereNotNull('driver_id')->where('status', 2)->get();

        return view('users.reports_drivers')->withDrivers($drivers)->withShipments($shipments);
    }
}
