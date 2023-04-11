{{-- @extends('print') --}}
{{-- @section('title', 'shipment print') --}}
{{-- @section('content') --}}
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="col-md-12 text-right toolbar-icon">
  <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
</div>
<div id="print_header" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">
  <div class="head" style="margin-bottom: 105px;margin-left: 20px;">
    <div class="col-md-6">
      <img src="{{ asset('img/logo.png') }}" alt="" style="width: 221px;  ">
    </div>
    <div class="col-md-6">
      <p style="float: right;border-left: 2px solid #000;padding: 11px;">
        <i class="fa fa-clock-o"></i> Time: 04:20 pm <br>
          <i class="fa fa-phone"></i> Phone:1234567890 <br>
          <i class="fa fa-envelope"></i> Email:ovalfleet.com
      </p>
    </div>
  
    
  </div>
  <div class="col-md-6">
    <table class="table">
      <tbody>
        <tr>
          <th>Shipper:</th>
          <td>{{$shipment->name}}</td>
        </tr>
        <tr>
          <th>Shipper Contact:</th>
          <td>{{$shipment->vinsn}}</td>
        </tr>
        <tr>
          <th>Fleet Owner:</th>
          <td>{{$shipment->license_plate}}</td>
        </tr>
        <tr>
          <th>Fleet Owner Contact:</th>
          <td>{{$shipment->shipment_type}}</td>
        </tr>
        <tr>
          <th>Dispatcher:</th>
          <td>{{$shipment->year}}</td>
        </tr>
        <tr>
          <th>Dispatcher Contact:</th>
          <td>{{$shipment->make}}</td>
        </tr>
        <tr>
          <th>Driver:</th>
          <td>{{$shipment->model_no}}</td>
        </tr>
        <tr>
          <th>Driver Contact :</th>
          <td>{{$shipment->province}}</td>
        </tr>
        <tr>
          <th>Packing Type:</th>
          <td>{{$shipment->packing_type}}</td>
        </tr>
        <tr>
          <th>Flammable?</th>
          <td>{{$shipment->flame == 'Flammable'?'Yes':'No'}}</td>
        </tr>
        <tr>
          <th>Loading Point:</th>
          <td>{{$shipment->loading_point}}</td>
        </tr>
        <tr>
          <th>Unload Point:</th>
          <td>{{$shipment->unload_point}}</td>
        </tr>
        <tr>
          <th>Loading Date:</th>
          <td>{{$shipment->loading_date}}</td>
        </tr>
        <tr>
          <th>Unload Date:</th>
          <td>{{$shipment->unload_date}}</td>
        </tr>
        <tr>
          <th>Loading Time:</th>
          <td>{{$shipment->loading_time}}</td>
        </tr>
        <tr>
          <th>Unload Time:</th>
          <td>{{$shipment->unload_time}}</td>
        </tr>


      </table>
    </div>
    <div class="col-md-6">
      <table class="table">
        <tbody>
         <tr>
          <th>Shipment Cost:</th>
          <td>{{$shipment->shipment_cost?'$'.$shipment->shipment_cost:''}}</td>
        </tr>
        <tr>
          <th>Quantity:</th>
          <td>{{$shipment->quantity}}</td>
        </tr>
        <tr>
          <th>Start Mileage</th>
          <td>{{$shipment->start_mileage}}</td>
        </tr>
        <tr>
          <th>End Mileage</th>
          <td>{{$shipment->end_mileage}}</td>
        </tr>
        <tr>
          <th>Vehicle License Plate</th>
          <td>
            @if(DB::table('vehicles')->find($shipment->vehicle_id))
            {{DB::table('vehicles')->find($shipment->vehicle_id)->license_plate}}
            @endif
          </td>
        </tr>
        <tr>
          <th>Starting Gas</th>
          <td>{{$shipment->starting_gas}}</td>
        </tr>
        <tr>
          <th>Location Distance Measurement:</th>
          <td>{{$shipment->location_distance}}</td>
        </tr>
        <tr>
          <th>Actual Distance:</th>
          <td>{{$shipment->actual_distance}}</td>
        </tr>
        <tr>
          <th>Total Distance:</th>
          <td>{{$shipment->total_distance}}</td>
        </tr>
        <tr>
          <th>Discount:</th>
          <td>{{$shipment->discount}}</td>
        </tr>
        <tr>
          <th>Extra Charge:</th>
          <td>{{$shipment->extra_charge}}</td>
        </tr>
        <tr>
          <th>TAX:</th>
          <td>{{$shipment->vat}}</td>
        </tr>
        <tr>
          <th>Status:</th>
          <td>
            @if($shipment->status == 0)
            <span class="label label-warning">Shipment process initiated</span>
            @elseif($shipment->status == 1)
            <span class="label label-success">Shipment in Transit</span>
            @elseif($shipment->status == 2)
            <span class="label label-danger">Shipment Completed</span>
            @endif
          </td>
        </tr>
        <tr>
          <th>Comment:</th>
          <td>{{$shipment->details}}</td>
        </tr>
        <tr>
          <th>Record Created On:</th>
          <td>{{date('d M Y h:i:s',strtotime($shipment->created_at) )}} </td>
        </tr>          
      </tbody>
    </table>

  </div>
  <div class="clearfix"></div>
</div>


{{-- @endsection --}}
