<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\User;
use App\Referral;
use Session;
use Mail;

class ReferralCtrl extends Controller
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
    public function resendInvitation($id)
    {
        $referral = Referral::find($id);
        $user = User::find($referral->refer_by);
        if($referral->sending_count > 4){
            Session::flash('error', 'Your resend email quota is over.');
            return redirect('/view_pending_referrals');
        }
        /* create data for email */
        $data = array(
            // 'name'         => $user->first_name.' '.$user->last_name,
            'user_id'      => $id,
            'email'        => $referral->email,
            'user_email'   => $user->email,
            'details'      => $referral->notes,
            'account_type' => $user->user_role,
            'host'         => SourceController::host()
        );

        /* sent invitation email function */
        Mail::send('emails.send_invitation', $data, function($message) use ($data){
            $message->from('do_not_reply@ovalfleet.com');
            $message->to($data['email']);
            $message->subject('Invitation to join OvalFleet.com');
        });

        //resend email count
        $referral->sending_count = $referral->sending_count+1;
        $referral->save();

        Session::flash('success', 'Your invitation mail has been resent successfully.');
        return redirect('/view_pending_referrals');
    }
    public function index()
    {
        $user = Auth::user();
        $users = User::where('referral', $user->id)->paginate(20);
        return view('users.view_referrals')->withUsers($users);
    }

    /* get all pending referrals */
    public function indexPending()
    {
        $user = Auth::user();
        $users = Referral::where('refer_by', $user->id)->where('status', 0)->paginate(20);
        return view('users.view_pending_referrals')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create_invitation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        //validate the data
        $this->validate($request, array(
            'email'   => 'email|required|max:50',
            'message' => 'max:9999'
        ));

        if(!empty($request->email)){

            /* refered item store to database */
            $create = New Referral;
            $create->refer_by   = $user->id;
            $create->email      = $request->email;
            $create->notes      = $request->message;
            $create->created_by = $user->id;
            $create->save();

            /* create data for email */
            $data = array(
                'user_id'      => $user->id,
                'name'         => $user->first_name.' '.$user->last_name,
                'email'        => $request->email,
                'user_email'   => $user->email,
                'details'      => $request->message,
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $referral = User::find($id);
        return view('users.read_referral')->withUser($referral);
    }

    public function pendingShow($id)
    {
        $user = User::find($id);
        return view('users.read_pending_referral')->withUser($user);
    }
}