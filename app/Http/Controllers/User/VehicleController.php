<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vehicle;
use App\Relation;
use Session;
use Image;
use File;
use PDF;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listofVehicles()
    {
        $user = Auth::user();
        $fleetowners = Relation::where('user_id', $user->id)->get();
        return view('users.view_listof_vehicles')->withFleetowners($fleetowners);
    }

    /* Associated with Fleet Owners */
    public function assocVehicles($id){
        $vehicles = Vehicle::where('user_id', $id)->paginate(20);
        return view('users.view_associated_vehicles')->withVehicles($vehicles);
    }

    public function readAssocVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        return view('users.read_associated_vehicle')->withVehicle($vehicle);
    }

    public function createVehicleShipment($section)
    {
        Session::put('section', $section);
        return view('users.create_vehicle')->withSection($section);
    }

    public function index()
    {
        $user = Auth::user();
        
        $flownids = [];
        if($user->user_role == 'Dispatcher'){
            $relations = Relation::where('user_id', $user->id)->get();
            foreach($relations as $relation){
                array_push($flownids, $relation->owner_id);
            }
            $vehicles = Vehicle::leftJoin('users', 'vehicles.user_id', 'users.id')->orderBy('vehicles.user_id', 'DESC')->whereIn('vehicles.user_id', $flownids)->where('vehicles.vehicle_status', '!=', 'Archived')->orWhereNull('vehicles.vehicle_status')->select('vehicles.*', 'users.first_name', 'users.last_name')->paginate(20);
        }else{
            $vehicles = Vehicle::leftJoin('users', 'vehicles.user_id', 'users.id')->orderBy('vehicles.id', 'DESC')->where('vehicles.user_id', $user->id)->where('vehicles.vehicle_status', '!=', 'Archived')->orWhereNull('vehicles.vehicle_status')->select('vehicles.*', 'users.first_name', 'users.last_name')->paginate(20);
        }
        return view('users.view_vehicles')->withVehicles($vehicles);
    }

    public function archive()
    {
        $user = Auth::user();
        $vehicles = Vehicle::leftJoin('users', 'vehicles.driver_id', 'users.id')->orderBy('vehicles.id', 'DESC')->where('vehicles.user_id', $user->id)->where('vehicles.vehicle_status', 'Archived')->select('vehicles.*', 'users.first_name', 'users.last_name')->paginate(20);
        return view('users.view_vehicles_archive')->withVehicles($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->user_role != 'Fleet Owner'){
            Session::flash('error', 'Permission Denied!');
            return redirect('/home');
        }
        if(Session::get('section')){
            Session::forget('section');
        }
        return view('users.create_vehicle');
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
            'name_type'       => 'max:255',
            'vinsn'           => 'max:255',
            'license_plate'   => 'max:255',
            'type'            => 'max:255',
            'year'            => 'max:255',
            'make'            => 'max:255',
            'model_no'        => 'max:255',
            'reg_state'       => 'max:255',
            'color'           => 'max:255',
            'body_type'       => 'max:255',
            'capacity'        => 'max:255',
            'current_mileage' => 'max:255',
            'purchase_date'   => 'max:255',
            'vehicle_status'  => 'max:255',
            'expense_record'  => 'max:255',
            'amount'          => 'max:255',
            'date'            => 'max:255',
            'expense_type'    => 'max:255',
            'vendor'          => 'max:255',
            'photo'           => 'image|mimes:jpg,jpeg,bmp,png|max:2000',
            'document'        => 'file|mimes:pdf,jpg,jpeg,png|max:2000',
            'comment'         => 'max:9999'
        ));
        if(count(Vehicle::where('vinsn', $request->vinsn)->where('license_plate', $request->license_plate)->get()) > 0){

            Session::flash('error', 'Vehicle already created!');
            return redirect('/create_vehicle');
        }

        //store in the database
        $create = new Vehicle;
        $create->user_id          = $user->id;
        $create->name_type        = $request->name_type;
        $create->vinsn            = $request->vinsn;
        $create->license_plate    = $request->license_plate;
        $create->vehicle_type     = $request->type;
        $create->year             = $request->year;
        $create->make             = $request->make;
        $create->model_no         = $request->model_no;
        $create->reg_state        = $request->reg_state;
        $create->color            = $request->color;
        $create->body_type        = $request->body_type;
        $create->capacity         = $request->capacity;
        $create->mileage          = $request->mileage;
        $create->purchase_date    = $request->purchase_date;
        $create->size             = $request->size;
        $create->date             = $request->date;
        $create->expense_type     = $request->expense_type;
        $create->vendor           = $request->vendor;
        $create->comments         = $request->comment;
        $create->details          = $request->details;
        $create->vehicle_status   = $request->vehicle_status;
        $create->expense_record   = $request->expense_record;
        $create->amount           = $request->amount;
        $create->created_by       = $user->id;

        //save image//
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/vehicles/' . $filename);
            Image::make($image)->resize(600, 400)->save($location);

            $create->photo = $filename;
        }
        if($request->hasFile('document')){
            $document = $request->file('document');
            $filename = time() . '.' . $document->getClientOriginalExtension();
            $location = ('img/vehicle_documents/');
            $document->move($location, $filename);

            $create->document = $filename;
        }

        $create->save();

        $last_vehicle = Vehicle::orderBy('id', 'DESC')->first();

        //session flashing
        Session::flash('success', 'Vehicle information successfully added!');
        
        if(!empty(Session::get('section'))){
            return redirect('/create_shipment');
            Session::forget('section');
        }else{
            //return to the show page
            return redirect('/vehicle/'.$last_vehicle->id.'/details');
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
        $vehicle = Vehicle::find($id);
        return view('users.read_vehicle')->withVehicle($vehicle);
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::find($id);
        return view('users.edit_vehicle')->withVehicle($vehicle);
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

            'name_type'       => 'max:255',
            'vinsn'           => 'max:255',
            'license_plate'   => 'max:255',
            'type'            => 'max:255',
            'year'            => 'max:255',
            'make'            => 'max:255',
            'model_no'        => 'max:255',
            'reg_state'       => 'max:255',
            'color'           => 'max:255',
            'body_type'       => 'max:255',
            'capacity'        => 'max:255',
            'current_mileage' => 'max:255',
            'purchase_date'   => 'max:255',
            'vehicle_status'  => 'max:255',
            'expense_record'  => 'max:255',
            'amount'          => 'max:255',
            'date'            => 'max:255',
            'expense_type'    => 'max:255',
            'vendor'          => 'max:255',
            'photo'           => 'image|mimes:jpg,jpeg,bmp,png|max:2000',
            'document'        => 'file|mimes:pdf,jpg,jpeg,png|max:2000',
            'comment'         => 'max:9999'
        ));
        
        $exvehicle = Vehicle::find($id);

        //store in the database
        $update = Vehicle::find($id);
        $update->name_type        = $request->name_type;
        $update->vinsn            = $request->vinsn;
        $update->license_plate    = $request->license_plate;
        $update->vehicle_type     = $request->type;
        $update->year             = $request->year;
        $update->make             = $request->make;
        $update->model_no         = $request->model_no;
        $update->reg_state        = $request->reg_state;
        $update->color            = $request->color;
        $update->body_type        = $request->body_type;
        $update->capacity         = $request->capacity;
        $update->mileage          = $request->mileage;
        $update->purchase_date    = $request->purchase_date;
        $update->size             = $request->size;
        $update->date             = $request->date;
        $update->expense_type     = $request->expense_type;
        $update->vendor           = $request->vendor;
        $update->comments         = $request->comment;
        $update->details          = $request->details;
        $update->vehicle_status   = $request->vehicle_status;
        $update->expense_record   = $request->expense_record;
        $update->amount           = $request->amount;
        $update->created_by       = $user->id;

        //save image//
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = ('img/vehicles/' . $filename);
            Image::make($image)->resize(600, 400)->save($location);

            $update->photo = $filename;
        }
        if($request->hasFile('document')){
            $document = $request->file('document');
            $filename = time() . '.' . $document->getClientOriginalExtension();
            $location = ('img/vehicle_documents/');
            $document->move($location, $filename);

            $update->document = $filename;
        }

        $update->save();

        if($request->hasFile('photo')){
            //delete exists image
            $exphoto = 'img/vehicles/'.$exvehicle->photo;
            if(File::exists($exphoto)){
                File::delete($exphoto);
            }
        }
        if($request->hasFile('document')) {
            //delete exists image
            $exdocument = 'img/vehicle_documents/'.$exvehicle->document;
            if(File::exists($exdocument)){
                File::delete($exdocument);
            }
        }

        //session flashing
        Session::flash('success', 'Vehicle information successfully updated!');
        
        //return to the show page
        return redirect('/vehicle/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::user();

        //find item and delete
        $vehicle = Vehicle::find($id);
        $vehicle->vehicle_status = 'Archived';
        $vehicle->updated_by = $user->id;
        $vehicle->save();

        //delete file
        // if($vehicle->photo){
        //     $exphoto = 'img/vehicles/'.$vehicle->photo;
        //     if(File::exists($exphoto)){
        //         File::delete($exphoto);
        //     }
        // }
        // if($vehicle->document){
        //     $exdocument = 'img/vehicle_documents/'.$vehicle->document;
        //     if(File::exists($exdocument)){
        //         File::delete($exdocument);
        //     }
        // }

        //flash the message
        Session::flash('success', 'Vehicle information has been successfully deleted.');

        //return to the index page
        return redirect('/view_vehicles');
    }

    public function returnToActive($id)
    {
        $update = Vehicle::find($id);
        $update->vehicle_status = 'Active';
        $update->save();

        //flash the message
        Session::flash('success', 'Vehicle information successfully restored from archive.');

        //return to the index page
        return redirect('/view_vehicles');
    }

    public function printVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        return view('users.print_vehicle')->withVehicle($vehicle);
    }

    //make pdf and download able
    public function pdf($id)
    {
        $vehicle = Vehicle::find($id);
        
        $pdf = PDF::loadView('users.pdf_vehicle', compact('vehicle'));
        return $pdf->stream('vehicle-'.$id.'.pdf');
        // return view('users.pdf_vehicle')->withVehicle($vehicle);
    }

    public function reports()
    {
        $user = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->id)->get();
        return view('users.reports_vehicles')->withVehicles($vehicles);
    }
}
