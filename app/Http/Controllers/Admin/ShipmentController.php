<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Shipment;
use App\Vehicle;
use App\User;
use App\Payment;
use Session;
use Image;

class ShipmentController extends Controller
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
        $user = Auth::user(); // logged in user
        $shipments = Shipment::orderBy('id', 'DESC')->paginate(20);
        return view('admins.view_shipments')->withShipments($shipments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createShipment()
    {
        $owner = Auth::user(); // logged in user

        $fleetowners = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Shipper')->select('users.*')->get();
        $drivers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Driver')->select('users.*')->get();
        $dispatchers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Dispatcher')->select('users.*')->get();
        $shippers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Shipper')->select('users.*')->get();
        $vehicles = Vehicle::where('user_id', $owner->id)->get();
        return view('admins.create_shipment')->withFleetowners($fleetowners)->withDrivers($drivers)->withDispatchers($dispatchers)->withShippers($shippers)->withVehicles($vehicles);
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
            'shipper'          => 'numeric',
            'dispatcher'       => 'required|numeric',
            'driver'           => 'numeric',
            'vehicle'          => 'numeric',
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
            'shipment_cost'    => 'max:999999',
            'details'          => 'max:255',
            'image'            => 'image'
        ));

        //store in the database
        $create = new Shipment;
        $create->shipper_id       = $request->shipper;
        $create->driver_id        = $request->driver;
        $create->dispatcher_id    = $request->dispatcher;
        $create->vehicle_id       = $request->vehicle;
        $create->packing_type     = $request->packing_type;
        $create->flame            = $request->flame;
        $create->loading_point    = $request->loading_point;
        $create->unload_point     = $request->unload_point;
        $create->loading_date     = $request->loading_date;
        $create->unload_date      = $request->unload_date;
        $create->loading_time     = $request->loading_time;
        $create->unload_time      = $request->unload_time;
        $create->shipment_cost    = $request->shipment_cost;
        $create->load_quantity    = $request->load_quantity;
        $create->user_id          = $creator->id;
        $create->actual_distance  = '';
        $create->total_distance   = '';
        $create->discount         = 0;
        $create->extra_charge     = 0;
        $create->goods_description= $request->goods_description;
        $create->vat              = 0;
        $create->status           = 1;
        $create->details          = $request->details;
        $create->created_by       = $creator->id;

        //save image//
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/profile/' . $filename);
            Image::make($image)->resize(600, 600)->save($location);

            $create->image = $filename;
        }

        $create->save();

        $shipment = Shipment::orderBy('id', 'DESC')->first();

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
        return view('users.read_shipment')->withShipment($shipment);
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
        $drivers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Driver')->select('users.*')->get();
        $dispatchers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Dispatcher')->select('users.*')->get();
        $shippers = User::leftJoin('relations', 'user_id', 'users.id')->where('owner_id', $owner->id)->where('users.user_role', 'Shipper')->select('users.*')->get();
        $vehicles = Vehicle::where('user_id', $owner->id)->get();
        $shipment = Shipment::find($id);
        return view('users.edit_shipment')->withDrivers($drivers)->withDispatchers($dispatchers)->withShippers($shippers)->withVehicles($vehicles)->withShipment($shipment);
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
            'shipper'          => 'numeric',
            'dispatcher'       => 'required|numeric',
            'driver'           => 'numeric',
            'vehicle'          => 'numeric',
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
            'shipment_cost'    => 'max:999999',
            'details'          => 'max:255',
            'image'            => 'image'
        ));

        //update in the database
        $update = Shipment::find($id);
        $update->shipper_id       = $request->input('shipper');
        $update->driver_id        = $request->input('driver');
        $update->dispatcher_id    = $request->input('dispatcher');
        $update->vehicle_id       = $request->input('vehicle');
        $update->packing_type     = $request->input('packing_type');
        $update->flame            = $request->input('flame');
        $update->loading_point    = $request->input('loading_point');
        $update->unload_point     = $request->input('unload_point');
        $update->loading_date     = $request->input('loading_date');
        $update->unload_date      = $request->input('unload_date');
        $update->loading_time     = $request->input('loading_time');
        $update->unload_time      = $request->input('unload_time');
        $update->shipment_cost    = $request->input('shipment_cost');
        $update->load_quantity    = $request->input('load_quantity');
        $update->user_id          = $creator->id;
        $update->actual_distance  = '';
        $update->total_distance   = '';
        $update->discount         = 0;
        $update->extra_charge     = 0;
        $update->goods_description= $request->input('goods_description');
        $update->vat              = 0;
        $update->status           = $request->input('status');
        $update->details          = $request->input('details');
        $update->updated_by       = $creator->id;

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
            'unload_time'      => 'max:255',
            'start_mileage'    => 'required|max:255',
            'end_mileage'      => 'required|max:255',
            'starting_gas'     => 'required|max:255',
            'location_distance'=> 'max:255',
            'details'          => 'max:255'
        ));

        //update in the database
        $update = Shipment::find($id);
        $update->unload_time      = $request->input('unload_time');
        $update->start_mileage    = $request->input('start_mileage');
        $update->end_mileage      = $request->input('end_mileage');
        $update->starting_gas     = $request->input('starting_gas');
        $update->location_distance= $request->input('location_distance');
        $update->details          = $request->input('details');
        $update->updated_by       = $user->id;

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
    public function destroy($id)
    {
        //find item and delete
        User::find($id)->delete();

        //flash the message
        Session::flash('success', 'Driver account has been successfully deleted.');

        //return to the index page
        return redirect('/view_driver_accounts');
    }

    /****************************** Reports Section **********************************/
    public function reports()
    {
        $shipments = Shipment::orderBy('id', 'DESC')->paginate(20);
        return view('admins.reports_shipment')->withShipments($shipments)->withShipsearches([]);
    }

    public function reportPost(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date'   => 'required|date'
            ]);

        $shipments = Shipment::orderBy('id', 'DESC')->paginate(20);

        $startdate = date('Y-m-d', strtotime($request->start_date));
        $enddate   = date('Y-m-d', strtotime($request->end_date));

        if(!empty($request->start_date) && !empty($request->end_date)){
            $shipsearch = Shipment::whereBetween('created_at', [$startdate, $enddate])->orderBy('id', 'DESC')->paginate(20);
            return view('admins.reports_shipment')->withShipments($shipments)->withShipsearches($shipsearch);
        }

        return redirect('/admin/reports_shipment');
    }

    public function financialReports()
    {
        $payments = Payment::orderBy('id', 'DESC')->paginate(20);
        return view('admins.reports_finance')->withPayments($payments);
    }
    public function financeReportPost(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date'   => 'required|date'
            ]);

        $shipments = Payment::orderBy('id', 'DESC')->paginate(20);
        
        $startdate = date('Y-m-d', strtotime($request->start_date));
        $enddate   = date('Y-m-d', strtotime($request->end_date));

        if(!empty($request->start_date) && !empty($request->end_date)){
            $shipments = Payment::whereBetween('created_at', [$startdate, $enddate])->orderBy('id', 'DESC')->paginate(20);
            return view('admins.reports_finance')->withPayments($shipments);
        }

        return redirect('/admin/reports_finance');
    }
}