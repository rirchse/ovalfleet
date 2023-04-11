<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use App\User;
use App\Shipment;
use App\Relation;
use App\Vehicle;
use Mail;
use Session;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user(); // logged in user
        $shipments = Shipment::where('user_id', $user->id)->select('*')->get();
        $users = Relation::leftJoin('users', 'relations.user_id', 'users.id')->where('relations.owner_id', $user->id)->get();
        $vehicles = Vehicle::where('user_id', $user->id)->get();
        return view('users.index')->withShipments($shipments)->withUsers($users)->withVehicles($vehicles);
    }

    public function create()
    {
        return view('homes.register');
    }

    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'first_name'     => 'required|max:50',
            'last_name'      => 'max:50',
            'email'          => 'required|max:50',
            'contact'        => 'required|max:18',
            'password'       => 'required|confirmed|min:8|max:32',
            'organization'   => 'max:50'
        ));

        //store in the database
        $user = new User;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->contact      = $request->contact;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);
        $user->organization = $request->organization;
        $user->save();

        //session flashing
        Session::flash('success', 'Sign up successfully completed!');
        
        //return to the show page
        return redirect('/login');
    }

    public function support()
    {
        return view('users.create_contact');
    }

    public function supportStore(Request $request)
    {
        $user = Auth::user();
        //validate the data
        $this->validate($request, array(
            'contact_for'  => 'required|max:50',
            'message'      => 'required|max:9999'
        ));

        /* create data for email */
        $data = array(
            'contact_for'    => $request->contact_for,
            'name'           => $user->first_name.' '.$user->last_name,
            'email'          => $user->email,
            'contact'        => $user->contact,
            'details'        => $request->message,
            'account_number' => $user->account_number,
            'account_type'   => $user->user_role,
            'host'           => SourceController::host()
        );

        // return view('emails.send_contact')
        // ->withName($data['name'])
        // ->withContact_for($data['contact_for'])
        // ->withDetails($data['details']);

        /* sent invitation email function */
        Mail::send('emails.send_contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('support@ovalfleet.com');
            $message->subject('Support Mail');
        });

        //session flashing
        Session::flash('success', 'Support Mail has been sent successfully.');
        
        //return to the show page
        return redirect('/create_contact');
    }

    public function calendar()
    {
        return view('users.test-calendar');
    }
}