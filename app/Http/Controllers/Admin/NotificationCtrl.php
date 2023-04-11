<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use Auth;

class NotificationCtrl extends Controller
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
        $alerts = Notification::leftJoin('users', 'users.id', 'notifications.user_id')->where('notifications.user_id', $user->id)->select('notifications.*', 'users.first_name', 'users.last_name')->orderBy('id', 'DESC')->paginate(20);
        return view('admins.view_notifications')->withAlerts($alerts);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alert = Notification::find($id);
        $alert->status = 1;
        $alert->save();

        return redirect($alert->url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notifications = Notification::where('status', 0)->where('user_type', 'Admin')->orderBy('id', 'DESC')->get();
        return response()->json($notifications);
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

    //customization
    public function storeAlert($title, $message, $url, $user, $created_by)
    {
        $notify = New Notification;
        $notify->title      = $title;
        $notify->message    = $message;
        $notify->url        = $url;
        $notify->user_id    = $user;
        $notify->created_by = $created_by;
        $notify->save();
    }
}
