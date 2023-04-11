<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\Notification;
use App\User;
use App\Ticket;
use App\Message;
use Session;
use Mail;

class TicketCtrl extends Controller
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
        $tickets = Ticket::orderBy('id', 'DESC')->get();
        return view('admins.view_tickets')->withTickets($tickets);
    }

    public function opened()
    {
        $tickets = Ticket::orderBy('id', 'DESC')->where('status', 0)->get();
        return view('admins.view_opened_tickets')->withTickets($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create_ticket');
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
            'reason'    => 'required|max:50',
            'message'   => 'required|max:9999'
        ));

        //store in the database
        $create = new Ticket;
        $create->reason     = $request->reason;
        $create->details    = $request->message;
        $create->ticket_id  = rand('99999','999999');
        $create->created_by = $user->id;
        $create->save();

        $ticket = Ticket::orderBy('id', 'DESC')->first();

        //session flashing
        Session::flash('success', 'New Ticket successfully submitted!');
        
        //return to the show page
        return redirect('/ticket/'.$ticket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();

        $ticket = Ticket::leftJoin('admins', 'tickets.support_by', 'admins.id')
        ->leftJoin('users', 'users.id', 'tickets.created_by')
        ->select('tickets.*', 'admins.first_name as adm_first_name', 'admins.last_name as adm_last_name', 'users.account_number', 'users.first_name', 'users.last_name', 'users.user_role', 'users.email')
        ->find($id);

        $messages = Message::orderBy('id', 'DESC')->where('ticket_id', $id)->get();

        return view('admins.read_ticket', compact('ticket', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    /* custom */

    public function provide(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        //validate the data        
        $this->validate($request, array(
            'note'     => 'required|max:9999'
        ));

        //store in the database
        $update = Ticket::find($id);
        $update->solution_at = date('Y-m-d H:i:s');
        $update->note        = $request->note;
        $update->status      = 1;
        $update->support_by  = $admin->id;
        $update->save();

        $ticket = Ticket::find($id);
        $user = User::find($ticket->created_by);

        /* create data for email */
        $data = array(
            'contact_for' => 'Thank you for support',
            'ticket_no'   => $ticket->ticket_id,
            'reason'      => $ticket->reason,
            'email'       => $user->email,
            'details'     => $ticket->details,
            'host'        => SourceController::host()
        );

        /* sent invitation email function */
        Mail::send('emails.close_ticket', $data, function($message) use ($data){
            $message->from('support@ovalfleet.com');
            $message->to($data['email']);
            $message->subject('Support Mail');
        });

        //session flashing
        Session::flash('success', 'Thank you for your support.');
        
        //return to the show page
        return redirect('/admin/ticket/'.$id);
    }

    public function close($id)
    {
        $update = Ticket::find($id);
        $update->status = 2;
        $update->save();

        //create notification
        $notify = New Notification;
        $notify->title      = 'Your ticket closed';
        $notify->message    = '';
        $notify->url        = '/ticket/'.$id;
        $notify->user_id    = $ticket->created_by;
        $notify->user_type  = 'User';
        $notify->created_by = Auth::id();
        $notify->save();

        //session flashing
        Session::flash('success', 'Ticket successfully closed!');
        
        //return to the show page
        return redirect('/admin/ticket/'.$id);
    }

    /* custom */
    public function reply(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required|max:999999'
            ]);
        $ticket = Ticket::find($id);

        $create = new Message;
        $create->ticket_id = $id;
        $create->user_id   = Auth::id();
        $create->user_type = 'Admin';
        $create->message   = $request->message;
        $create->created_by= Auth::id();
        $create->save();

        //create notification
        $notify = New Notification;
        $notify->title      = 'You got a reply';
        $notify->message    = '';
        $notify->url        = '/ticket/'.$id;
        $notify->user_id    = $ticket->created_by;
        $notify->user_type  = 'User';
        $notify->created_by = Auth::id();
        $notify->save();

        Session::flash('success', 'Message sent successfully.');
        return redirect('/admin/ticket/'.$id);
    }
}