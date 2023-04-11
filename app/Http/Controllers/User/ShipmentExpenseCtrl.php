<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Shipment;
use App\ShipmentExpense;
use App\User;
use Session;

class ShipmentExpenseCtrl extends Controller
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
    public function index($id)
    {
        $user = Auth::user(); //loged user
        $shipment = Shipment::find($id);
        $expenses = ShipmentExpense::where('shipment_id', $id)->paginate(20);
        return view('users.view_shipment_expenses')->withShipment($shipment)->withExpenses($expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $shipment = Shipment::find($id);
        return view('users.create_shipment_expense')->withShipment($shipment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user(); //loged user
        $this->validate($request, [
            'cause'       => 'required|max:255',
            'date'        => 'required|max:255',
            'start_time'  => 'max:255',
            'end_time'    => 'max:255',
            'expense'     => 'max:99999',
            'notes'       => 'max:999',
            'shipment_id' => 'required|numeric|nullable',
            'driver_id'   => 'required|numeric|nullable',
            ]);

        $shipmentExp = ShipmentExpense::where('shipment_id', $request->shipment_id)->where('driver_id', $request->driver_id)->where('cause', $request->cause)->where('start_time', $request->start_time)->where('expense', $request->expense)->get();

        if(count($shipmentExp) > 1){
            Session::flash('error', 'This expense is already recorded!');
            return redirect('/create/shipment/'.$request->shipment_id.'/expense');
        }

        $create = New ShipmentExpense;
        $create->shipment_id = $request->shipment_id;
        $create->driver_id   = $request->driver_id;
        $create->cause       = $request->cause;
        $create->date        = date('Y-m-d', strtotime($request->date));
        $create->start_time  = date('H:i:s', strtotime($request->start_time));
        $create->end_time    = date('H:i:s', strtotime($request->end_time));
        $create->expense     = $request->expense;
        $create->status      = 1;
        $create->notes       = $request->notes;
        $create->created_by  = $user->id;
        $create->save();

        Session::flash('success', 'Expense successfully recorded!');
        return redirect('/create_shipment/'.$request->shipment_id.'/expense');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $expid)
    {
        $shipment = Shipment::find($id);
        $expense = ShipmentExpense::find($expid);
        return view('users.read_shipment_expense')->withShipment($shipment)->withExpense($expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $expid)
    {
        $shipment = Shipment::find($id);
        $expense = ShipmentExpense::find($expid);
        return view('users.edit_shipment_expense')->withShipment($shipment)->withExpense($expense);
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
        $user = Auth::user(); //loged user
        $this->validate($request, [
            'cause'       => 'required|max:255',
            'date'        => 'required|max:255',
            'start_time'  => 'max:255',
            'end_time'    => 'max:255',
            'expense'     => 'max:99999',
            'note'        => 'max:999999',
            'shipment_id' => 'numeric|nullable',
            'driver_id'   => 'numeric|nullable',
            ]);

        $update = ShipmentExpense::find($id);
        // $update->shipment_id = $request->shipment_id;
        $update->driver_id   = $request->input('driver_id');
        $update->cause       = $request->input('cause');
        $update->date        = date('Y-m-d', strtotime($request->input('date')));
        $update->start_time  = date('H:i:s', strtotime($request->input('start_time')));
        $update->end_time    = date('H:i:s', strtotime($request->input('end_time')));
        $update->expense     = $request->input('expense');
        $update->status      = 1;
        $update->notes       = $request->input('notes');
        $update->updated_by  = $user->id;
        $update->save();

        Session::flash('success', 'Expense successfully updated!');
        return redirect('/shipment/'.$request->shipment_id.'/expense/'.$id.'/edit');
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

    public function delete($id, $expid)
    {
        ShipmentExpense::find($expid)->delete();
        return redirect('/view_shipment/'.$id.'/expenses');
    }
}