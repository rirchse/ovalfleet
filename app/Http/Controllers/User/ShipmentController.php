<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\Notification;
use App\Shipment;
use App\ShipmentExpense;
use App\Vehicle;
use App\Relation;
use App\User;
use Session;
use Mail;
use Image;
use PDF;

class ShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* Associated with Fleet Owners */
    public function assocShipments($id){
        $shipments = Shipment::where('user_id', $id)->paginate(20);
        return view('users.view_associated_shipments')->withShipments($shipments);
    }

    public function index()
    {
        $user = Auth::user(); // logged in user
        $flowners = [];
        $shipments = [];
        if($user->user_role == 'Dispatcher'){
            $fleetowners = Relation::where('user_id', $user->id)->select('owner_id')->get();
            foreach($fleetowners as $fleetowner){
                array_push($flowners, $fleetowner->owner_id);
            }
            $shipments = Shipment::orderBy('id', 'DESC')->whereIn('fleetowner_id', $flowners)->paginate(20);
        }elseif($user->user_role == 'Fleet Owner'){
            $shipments = Shipment::orderBy('id', 'DESC')->where('fleetowner_id', $user->id)->paginate(20);
        }elseif($user->user_role == 'Shipper'){
            $shipments = Shipment::orderBy('id', 'DESC')->where('shipper_id', $user->id)->paginate(20);
        }elseif($user->user_role == 'Driver'){
            $shipments = Shipment::orderBy('id', 'DESC')->where('driver_id', $user->id)->paginate(20);
        }
        
        return view('users.view_shipments')->withShipments($shipments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owner = Auth::user(); // logged in user
        if($owner->user_role != 'Fleet Owner' && $owner->user_role != 'Dispatcher'){
            return redirect('/home');
        }

        /* account expire calculation */
        if(UserController::accountExpire() == true){
            return redirect('/select_package');
        }

    $fleetowners = $dispatchers = $shippers = $vehicles = $drivers = [];
    if($owner->user_role == 'Dispatcher'){
        $fleetowners = User::leftJoin('relations', 'relations.owner_id', 'users.id')->where('relations.user_id', $owner->id)->select('users.id', 'users.first_name', 'users.last_name')->get();

    } else {
        
        $fleetowners = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Fleet Owner')->select('users.*')->get();
        $drivers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Driver')->select('users.*')->get();
        $dispatchers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Dispatcher')->select('users.*')->get();
        $shippers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Shipper')->select('users.*')->get();
        $vehicles = Vehicle::where('user_id', $owner->id)->where('vehicle_status', 'Active')->get();
    }

        return view('users.create_shipment')->withDrivers($drivers)->withDispatchers($dispatchers)->withShippers($shippers)->withVehicles($vehicles)->withFleetowners($fleetowners);
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
            'fleet_owner'      => 'numeric|nullable',
            'shipper'          => 'required|numeric|nullable',
            'dispatcher'       => 'numeric|nullable',
            'driver'           => 'numeric|nullable',
            'vehicle'          => 'numeric|nullable',
            'goods_description'=> 'max:99999',
            'load_quantity'    => 'required|max:255',
            'packing_type'     => 'max:255',
            'flame'            => 'max:255',
            'loading_point'    => 'required|max:255',
            'loading_date'     => 'required|min:10|max:18',
            'loading_time'     => 'required|max:255',
            'unload_point'     => 'max:255',
            'unload_date'      => 'max:255',
            'unload_time'      => 'max:255',
            'distance'         => 'max:255',
            'duration'         => 'max:255',
            'shipment_cost'    => 'max:999999',
            'dispatcher_commission'=> 'max:999999',
            'driver_commission'    => 'max:999999',
            'dispatcher_percent'   => 'max:100',
            'driver_percent'       => 'max:100',
            'details'          => 'max:255',
            'image'            => 'image'
        ));

        $shipment = Shipment::where('shipment_cost', $request->shipment_cost)->where('loading_point', $request->loading_point)->where('unload_point', $request->unload_point)->first();
        if($shipment){
            Session::flash('error', 'Shipment already created.');
            return redirect('/create_shipment');
        }

        //store in the database
        $create = new Shipment;
        $create->fleetowner_id    = $user->user_role == 'Fleet Owner'?$user->id:$request->fleet_owner;
        $create->shipper_id       = $request->shipper;
        $create->driver_id        = $request->driver;
        $create->dispatcher_id    = $user->user_role == 'Dispatcher'?$user->id:$request->dispatcher;
        $create->vehicle_id       = $request->vehicle;
        $create->packing_type     = $request->packing_type;
        $create->flame            = $request->flame;
        $create->loading_point    = $request->loading_point;
        $create->unload_point     = $request->unload_point;
        $create->loading_date     = date('Y-m-d',strtotime($request->loading_date));
        $create->unload_date      = date('Y-m-d',strtotime($request->unload_date));
        $create->loading_time     = date('H:i:s', strtotime($request->loading_time));
        $create->unload_time      = date('H:i:s', strtotime($request->unload_time));
        $create->shipment_cost    = $request->shipment_cost;
        $create->dispatcher_commission = $request->dispatcher_commission;
        $create->driver_commission     = $request->driver_commission;
        $create->dispatcher_percent    = $request->dispatcher_percent;
        $create->driver_percent        = $request->driver_percent;
        $create->load_quantity    = $request->load_quantity;
        $create->user_id          = $user->id;
        $create->distance         = $request->distance;
        $create->duration         = $request->duration;
        $create->discount         = 0;
        $create->extra_charge     = 0;
        $create->goods_description= $request->goods_description;
        $create->vat              = 0;
        $create->status           = 0;
        $create->details          = $request->details;
        $create->created_by       = $user->id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $create->image = $filename;
        }

        $create->save();

        function create_notification($user_id, $itemid){
            $user = Auth::user();
            $notify = New Notification;
            $notify->title      = 'Shipment Created.';
            $notify->message    = 'Shipment Created.';
            $notify->url        = '/shipment/'.$itemid.'/details';
            $notify->user_id    = $user_id;
            $notify->created_by = $user->id;
            $notify->save();
        }

        $shipment = Shipment::orderBy('id', 'DESC')->first();

        //create notification for connected users with shipment
        if($shipment->fleetowner_id){
            create_notification($shipment->fleetowner_id, $shipment->id);
        }
        if($shipment->dispatcher_id){
            create_notification($shipment->dispatcher_id, $shipment->id);
        }
        if($shipment->shipper_id){
            create_notification($shipment->shipper_id, $shipment->id);
        }
        if($shipment->driver_id){
            create_notification($shipment->driver_id, $shipment->id);
        }

        //session flashing
        Session::flash('success', 'Shipment successfully created!');
        
        //return to the show page
        return redirect('/shipment/'.$shipment->id.'/details');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $shipment = Shipment::find($id);

       //shipment is not exists 
       if(empty($shipment)){
        return redirect('/view_shipments');
       }

        return view('users.read_shipment')->withShipment($shipment);
    }

    public function readAssocShipment($id)
    {
        $shipment = Shipment::find($id);
        return view('users.read_associated_shipment')->withShipment($shipment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owner = Auth::user(); // logged in user

        if($owner->user_role == 'Driver'){
            return redirect('/shipment/driver/'.$id.'/edit');
        }

        $fleetowners = $dispatchers = $shippers = $vehicles = $drivers = [];
        if($owner->user_role == 'Dispatcher'){
            $fleetowners = User::leftJoin('relations', 'relations.owner_id', 'users.id')->where('relations.user_id', $owner->id)->select('users.id', 'users.first_name', 'users.last_name')->get();

        } else {
            
            $fleetowners = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Fleet Owner')->select('users.*')->get();
            $drivers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Driver')->select('users.*')->get();
            $dispatchers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Dispatcher')->select('users.*')->get();
            $shippers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Shipper')->select('users.*')->get();
            $vehicles = Vehicle::where('user_id', $owner->id)->where('vehicle_status', 'Active')->get();
        }
        $shipment = Shipment::find($id);
        return view('users.edit_shipment')->withFleetowners($fleetowners)->withDrivers($drivers)->withDispatchers($dispatchers)->withShippers($shippers)->withVehicles($vehicles)->withShipment($shipment);
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
            'fleet_owner'      => 'numeric|nullable',
            'shipper'          => 'required|numeric|nullable',
            'dispatcher'       => 'numeric|nullable',
            'driver'           => 'numeric|nullable',
            'vehicle'          => 'numeric|nullable',
            'goods_description'=> 'max:99999',
            'load_quantity'    => 'required|max:255',
            'packing_type'     => 'max:255',
            'flame'            => 'max:255',
            'loading_point'    => 'required|max:255',
            'loading_date'     => 'required|min:10|max:18',
            'loading_time'     => 'required|max:255',
            'unload_point'     => 'max:255',
            'unload_date'      => 'max:255',
            'unload_time'      => 'max:255',
            'distance'         => 'max:255',
            'duration'         => 'max:255',
            'shipment_cost'    => 'max:999999',
            'extra_charge'     => 'max:999999',
            'extra_charge_reason'  => 'max:9999',
            'dispatcher_commission'=> 'max:999999',
            'driver_commission'    => 'max:999999',
            'dispatcher_percent'   => 'max:100',
            'driver_percent'       => 'max:100',
            'details'          => 'max:255',
            'image'            => 'image'
        ));

// dd($request->input('shipper'));

        //update in the database
        $update = Shipment::find($id);
        $update->fleetowner_id    = $user->user_role == 'Fleet Owner'?$user->id:$request->input('fleet_owner');
        $update->shipper_id       = $request->input('shipper');
        $update->driver_id        = $request->input('driver');
        $update->dispatcher_id    = $user->user_role == 'Dispatcher'?$user->id:$request->input('dispatcher');
        $update->vehicle_id       = $request->input('vehicle');
        $update->packing_type     = $request->input('packing_type');
        $update->flame            = $request->input('flame');
        $update->loading_point    = $request->input('loading_point');
        $update->unload_point     = $request->input('unload_point');
        $update->loading_date     = date('Y-m-d', strtotime($request->input('loading_date')));
        $update->unload_date      = date('Y-m-d', strtotime($request->input('unload_date')));
        $update->loading_time     = date('H:i:s', strtotime($request->input('loading_time')));
        $update->unload_time      = date('H:i:s', strtotime($request->input('unload_time')));
        $update->shipment_cost    = $request->input('shipment_cost');
        $update->dispatcher_commission = $request->input('dispatcher_commission');
        $update->driver_commission     = $request->input('driver_commission');
        $update->dispatcher_percent    = $request->input('dispatcher_percent');
        $update->driver_percent        = $request->input('driver_percent');
        $update->load_quantity    = $request->input('load_quantity');
        $update->distance         = $request->input('distance');
        $update->duration         = $request->input('duration');
        $update->discount         = 0;
        $update->extra_charge     = $request->input('extra_charge');
        $update->extra_charge_reason   = $request->input('extra_charge_reason');
        $update->goods_description= $request->input('goods_description');
        $update->vat              = 0;
        $update->details          = $request->input('details');
        $update->updated_by       = $user->id;

        //save image//
        if($request->hasFile('image')){
            $image    = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $update->image = $filename;
        }

        $update->save();

        //session flashing
        Session::flash('success', 'Shipment successfully updated!');
        
        //return to the show page
        return redirect('/shipment/'.$id.'/edit');
    }

    public function activeShipments()
    {
        $user = Auth::user();
        $shipments = Shipment::where('driver_id', $user->id)->where('status', 1)->paginate(20);
        return view('users.view_active_shipments_driver')->withShipments($shipments);
    }

    public function completedShipments()
    {
        //status: 0 = new created, 1 = active, 2 = completed
        $user = Auth::user();
        $shipments = Shipment::where('driver_id', $user->id)->where('status', 2)->paginate(20);
        return view('users.view_completed_shipments_driver')->withShipments($shipments);
    }

    public function editShipmentDriver($id)
    {
        $user = Auth::user();
        $shipment = Shipment::find($id);
        if($user->id == $shipment->driver_id){
            return view('users.edit_shipment_driver')->withShipment($shipment);
        }
    }

    public function updateShipmentdriver(Request $request, $id)
    {
        $user = Auth::user();
        //validate the data        
        $this->validate($request, array(
            'load_start_time'      => 'max:255',
            'load_complete_time'   => 'max:255',
            'down_time'            => 'max:255',
            'in_transit_expense'   => 'max:255',
            'reached_unload_point' => 'max:255',
            'unload_complete_time' => 'max:255',
            'start_mileage'        => 'max:255',
            'end_mileage'          => 'max:255',
            'starting_gas'         => 'max:255',
            'details'              => 'max:255'
        ));

        function getdt($dt){
            return date('H:i:s', strtotime($dt));
        }

        //update in the database
        $update = Shipment::find($id);
        $update->arrived_load_point     = date('H:i:s', strtotime($request->input('load_start_time')));
        $update->load_complete_time     = date('H:i:s', strtotime($request->input('load_complete_time')));
        $update->reached_unload_point   = date('H:i:s', strtotime($request->input('reached_unload_point')));
        $update->unload_complete_time   = date('H:i:s', strtotime($request->input('unload_complete_time')));
        $update->start_mileage          = $request->input('start_mileage');
        $update->end_mileage            = $request->input('end_mileage');
        $update->starting_gas           = $request->input('starting_gas');
        $update->details                = $request->input('details');
        $update->updated_by             = $user->id;

        $update->save();

        //session flashing
        Session::flash('success', 'Shipment successfully updated!');
        
        //return to the show page
        return redirect('/shipment/driver/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        $shipment = Shipment::find($id);
        if(ShipmentExpense::where('shipment_id', $id)->get()){
            foreach(ShipmentExpense::where('shipment_id', $id)->get() as $shipmentexp){
                $shipmentexp->delete();
            }            
        }

        $shipment->delete();

        Session::flash('success', 'Shipment has been successfully deleted.');

        //return to the index page
        return redirect('/view_shipments');
    }

    public function destroy($id)
    {
        //find item and delete
        User::find($id)->delete();

        //flash the message
        Session::flash('success', 'Driver account has been successfully deleted.');

        //return to the index page
        return redirect('/view_driver_accounts');
    }

    public function showPdf($id)
    {
        $shipment = Shipment::find($id);
        return view('users.pdf_shipment')->withShipment($shipment);
    }

    public function pdf($id)
    {
        $shipment = Shipment::find($id);

        $pdf = PDF::loadView('users.pdf_shipment', compact('shipment'));
        return $pdf->stream('shipment-'.$id.'.pdf');
        // return $pdf->download('shipment-'.$id.'.pdf');
        // return view('users.pdf_shipment')->withShipment($shipment);
    }

    public function changeStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:999',
            'confirm_note' => 'required|max:999'
            ]);
        $alert_msg = '';
        $user = Auth::user();
        $shipment = Shipment::find($id);

        $update = Shipment::find($id);
        if($shipment->status == 0){
            $alert_msg = 'Shipment Ready for Pick up.';
            $update->confirm_by = $user->id;
            $update->confirm_note = $shipment->confirm_note.'<b>Ready for pick up note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
            $update->status = 1;
        }elseif($shipment->status == 1){
            
            if($request->status == 5){
                $alert_msg = 'Shipment Cancelled.';
                $update->cancelled_by = $user->id;
                $update->confirm_note = $shipment->confirm_note.'<b>Cancellation note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
                $update->status = 5;
            }else{

                if($update->loading_date > date('Y-m-d')){
                    Session::flash('error', 'You can change this status to \'in-transit\' after the loading date and time is met. Loading date: '.date('d M Y', strtotime($update->loading_date)));
                    return redirect('/shipment/'.$update->id.'/details');
                }

                $alert_msg = 'Shipment in transit.';
                $update->intransit_by = $user->id;
                $update->confirm_note = $shipment->confirm_note.'<b>In transit note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
                $update->status = 2;
            }
        }elseif($shipment->status == 2){
            $alert_msg = 'Shipment successfully delivered.';
            $update->delivered_by = $user->id;
            $update->confirm_note = $shipment->confirm_note.'<b>Delivered note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
            $update->status = 3;
        }elseif($shipment->status == 3){
            $alert_msg = 'Shipment successfully completed.';
            $update->complete_by = $user->id;
            $update->confirm_note = $shipment->confirm_note.'<b>Completed note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
            $update->status = 4;
            // $update->save();
            $this->complete($shipment->id);
        }elseif($shipment->status == 4){
            
        }elseif($shipment->status == 5){
            $alert_msg = 'Shipment retrieved to initiated.';
            $update->confirm_by   = 0;
            $update->intransit_by = 0;
            $update->delivered_by = 0;
            $update->complete_by  = 0;
            $update->cancelled_by = 0;
            $update->confirm_note = '<b>Retrieved note: ('.date('d M Y h:i A').')</b> '.$request->confirm_note.'<br>';
            $update->status = 0;
        }
        $update->save();

        Session::flash('success', $alert_msg);
        return redirect('/shipment/'.$id.'/details');
    }

    public function complete($id)
    {
        $user = Auth::user();
        $shipment = Shipment::find($id);

        function create_notification($user_id, $itemid){
            $user = Auth::user();
            $notify = New Notification;
            $notify->title      = 'Shipment Completed.';
            $notify->message    = 'Shipment Completed.';
            $notify->url        = '/shipment/'.$itemid.'/details';
            $notify->user_id    = $user_id;
            $notify->created_by = $user->id;
            $notify->save();
        }
        if($user->user_role == 'Fleet Owner' && $shipment->fleetowner_id == $user->id || $user->user_role == 'Dispatcher' && $shipment->dispatcher_id == $user->id){

            //create notification for connected users with shipment
            if($shipment->fleetowner_id){
                create_notification($shipment->fleetowner_id, $shipment->id);
            }
            if($shipment->dispatcher_id){
                create_notification($shipment->dispatcher_id, $shipment->id);
            }
            if($shipment->shipper_id){
                create_notification($shipment->shipper_id, $shipment->id);
            }
            if($shipment->driver_id){
                create_notification($shipment->driver_id, $shipment->id);
            }

            //email to Shipper
            if($shipment->shipper_id){
                $shipper = User::find($shipment->shipper_id);
                /* create data for email */
                $data = array(
                    'name'         => $shipper->first_name.' '.$shipper->last_name,
                    'email'        => $shipper->email,
                    'user_email'   => $user->email,
                    'shipment_id'  => $shipment->id,
                    'details'      => '',
                    'account_type' => '',
                    'host'         => SourceController::host()
                );

                /* sent shipment complete */
                Mail::send('emails.send_shipment_complete', $data, function($message) use ($data){
                    $message->from('do_not_reply@ovalfleet.com');
                    $message->to($data['email']);
                    $message->subject('Shipment Complete');
                });
            }

            Session::flash('success', 'Shipment Completed.');
        }
        
        // return redirect('/shipment/'.$id.'/details');
    }

    /****************************** Reports Section **********************************/
    public function reports()
    {
        $user = Auth::user();
        $shipments = Shipment::where('fleetowner_id', $user->id)->orderBy('id', 'DESC')->paginate(20);
        return view('users.reports_shipment')->withShipments($shipments)->withShipsearches([]);
    }

    public function reportPost(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date'   => 'required|date'
            ]);

        $shipments = Shipment::where('fleetowner_id', $user->id)->orderBy('id', 'DESC')->paginate(20);
        
        $startdate = date('Y-m-d', strtotime($request->start_date));
        $enddate   = date('Y-m-d', strtotime($request->end_date));

        if(!empty($request->start_date) && !empty($request->end_date)){
            $shipsearch = Shipment::where('fleetowner_id', $user->id)->whereBetween('created_at', [$startdate, $enddate])->orderBy('id', 'DESC')->paginate(20);
            return view('users.reports_shipment')->withShipments($shipments)->withShipsearches($shipsearch);
        }

        return redirect('/reports_shipment');
    }

    public function financialReports()
    {
        $user = Auth::user();
        $shipments = Shipment::where('fleetowner_id', $user->id)->orderBy('status', 'ASC')->get();
        return view('users.reports_finance')->withShipments($shipments);
    }
    public function financeReportPost(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date'   => 'required|date'
            ]);

        $shipments = Shipment::where('fleetowner_id', $user->id)->orderBy('status', 'ASC')->get();
        
        $startdate = date('Y-m-d', strtotime($request->start_date));
        $enddate   = date('Y-m-d', strtotime($request->end_date));

        if(!empty($request->start_date) && !empty($request->end_date)){
            $shipments = Shipment::where('fleetowner_id', $user->id)->whereBetween('created_at', [$startdate, $enddate])->orderBy('id', 'DESC')->get();
            return view('users.reports_finance')->withShipments($shipments)->withShipsearches($shipments);
        }

        return redirect('/reports_finance');
    }

    public function financialDetails()
    {        
        $user = Auth::user();
        $usertype = $user->user_role.'_id';
        $financials = Shipment::where($usertype, $user->id)->whereIn('status', [2,3,4])->paginate(20);
        return view('users.view_financial_details')->withShipments($financials);
    }

    public function byStatus($status)
    {
        $user = Auth::user();
        $shipments = Shipment::where('fleetowner_id', $user->id)->where('status', $status)->orderBy('id', 'DESC')->get();
        return view('users.reports_shipment')->withShipments($shipments)->withShipsearches($shipments);
    }

    /****************************** Drivers Control **********************************/

    public function activeShipmentsDriver()
    {
        $user = Auth::user();
        $shipments = Shipment::where('driver_id', $user->id)->where('status', 1)->paginate(20);
        return view('users.view_active_shipments_driver')->withShipments($shipments);
    }
    public function detailsShipmentDriver($id)
    {
        $shipment = Shipment::find($id);
        return view('users.read_shipment_driver')->withShipment($shipment);
    }
}