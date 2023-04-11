<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\Notification;
use App\Ticket;
use App\Message;
use Session;
use Mail;

class TicketCtrl extends Controller
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
        $user = Auth::user();
        $tickets = Ticket::orderBy('id', 'DESC')->where('created_by', $user->id)->paginate(20);
        return view('users.view_tickets')->withTickets($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create_ticket');
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
            'reason'    => 'required|max:150',
            'message'   => 'required|max:9999',
            'image'     => 'mimes:jpeg,png,pdf'
        ));

        $ticketID = Ticket::max('ticket_id');

        //store in the database
        $create = new Ticket;
        $create->reason     = $request->reason;
        $create->details    = $request->message;
        $create->ticket_id  = $ticketID > 0 ? $ticketID+1 : 111111;
        $create->created_by = $user->id;


        if($request->hasFile('image')){
            $file            = $request->file('image');
            $file_name       = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/support_ticket');
            $file->move($destinationPath, $file_name);
            $create->file    = $file_name;
        }

        $create->save();

        $ticket = Ticket::orderBy('id', 'DESC')->first();

        //create notification
        $notify = New Notification;
        $notify->title      = 'New ticket';
        $notify->message    = '';
        $notify->url        = '/admin/ticket/'.$ticket->id;
        $notify->user_id    = 0;
        $notify->user_type  = 'Admin';
        $notify->created_by = Auth::id();
        $notify->save();

        /* create data for email */
        $data = array(
            'contact_for' => 'Request for support',
            'ticket_no'   => $ticket->ticket_id,
            'reason'      => $ticket->reason,
            'email'       => $user->email,
            'name'        => $user->first_name.' '.$user->last_name,
            'account_no'  => $user->account_number,
            'account_type'=> $user->user_role,
            'details'     => $ticket->details,
            'host'        => SourceController::host()
        );

        /* sent email to support team */
        Mail::send('emails.create_ticket_support', $data, function($message) use ($data){
            $message->from('do_not_reply@ovalfleet.com');
            $message->to('ovalfleet.ticket@gmail.com');
            $message->subject('Support Mail');
        });

        /* sent email to the customer */
        Mail::send('emails.create_ticket', $data, function($message) use ($data){
            $message->from('do_not_reply@ovalfleet.com');
            $message->to($data['email']);
            $message->subject('Support Mail');
        });

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
        $ticket = Ticket::leftJoin('admins', 'tickets.support_by', 'admins.id')->select('tickets.*', 'admins.first_name', 'admins.last_name')->find($id);
        $messages = Message::orderBy('id', 'DESC')->where('ticket_id', $id)->get();
        return view('users.read_ticket', compact('ticket', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        return view('users.edit_ticket')->withTicket($ticket);
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
        $user = Auth::user();
        //validate the data        
        $this->validate($request, array(
            'reason'    => 'required|max:150',
            'message'   => 'required|max:9999',
            'image'     => 'mimes:jpeg,png,pdf'
        ));

        //store in the database
        $update = Ticket::find($id);
        $update->reason       = $request->input('reason');
        $update->details      = $request->input('message');
        $update->updated_by   = $user->id;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/support_ticket');
            $file->move($destinationPath, $file_name);
            $update->file    = $file_name;
        }

        $update->save();

        //session flashing
        Session::flash('success', 'Ticket successfully updated and submitted!');
        
        //return to the show page
        return redirect('/ticket/'.$id);
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
        Ticket::find($id)->delete();

        //flash the message
        Session::flash('success', 'Ticket has been successfully deleted.');

        //return to the index page
        return redirect('/ticket');
    }

    /* custom */
    public function reply(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required|max:999999'
            ]);
        $create = new Message;
        $create->ticket_id = $id;
        $create->user_id   = Auth::id();
        $create->user_type = 'User';
        $create->message   = $request->message;
        $create->created_by= Auth::id();
        $create->save();

        //create notification
        $notify = New Notification;
        $notify->title      = 'You got a response.';
        $notify->message    = '';
        $notify->url        = '/admin/ticket/'.$id;
        $notify->user_id    = 0;
        $notify->user_type  = 'Admin';
        $notify->created_by = Auth::id();
        $notify->save();

        Session::flash('success', 'Message sent successfully.');
        return redirect('/ticket/'.$id);
    }

    /* give a feedback */
    public function feedback($id, $fb)
    {
        $user = Auth::user();

        //store in the database
        $feedback = Ticket::find($id);
        $feedback->feedback  = $fb;
        $feedback->status    = 2;
        $feedback->closed_at = date('Y-m-d H:i:s');
        $feedback->save();

        //session flashing
        Session::flash('success', 'Your feedback is successfully sent! Thank you.');
        
        //return to the show page
        return redirect('/ticket/'.$id);
    }
}