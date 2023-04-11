<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shipment</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
</head>
<body>
  <div id="print_header" class="container" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">
    <table style="width:100%">
      <tr>
        <td style="vertical-align:top"><img src="{{ asset('img/logo.png') }}" alt="" style="width: 221px;"></td>
        <td>
          <div style="text-align:right!important; vertical-align:top">
            Record Created On: {{date('d M Y h:i:s',strtotime($shipment->created_at) )}}<br>
            Created By: {{$shipment->created_by?App\User::find($shipment->created_by)->user_role:'..................'}}<br>
            Updated By: {{$shipment->updated_by?App\User::find($shipment->updated_by)->user_role:'..................'}}<br>
            Confirm By: {{$shipment->confirm_by?App\User::find($shipment->confirm_by)->user_role:'..................'}}<br>
            Complete By: {{$shipment->complete_by?App\User::find($shipment->complete_by)->user_role:'..................'}}
          </div>
        </td>
      </tr>
    </table>

    <b>Shipment related user information</b>
    <table style="width:100%">
      <tr>
        @if(App\User::find($shipment->fleetowner_id))
        <td style="border:1px solid; padding: 10px 15px">
          <b style="border-bottom:1px solid">Fleet Owner Information:</b>
          <?php $flowner = App\User::find($shipment->fleetowner_id); ?>
          <label><b>Name:</b> {{$flowner->first_name.' '.$flowner->last_name}}</label><br>
          <label><b>Contact:</b> +{{$flowner->contact}}</label><br>
          <label><b>Email:</b> {{$flowner->email}}</label><br>
          <label><b>Address:</b> {{$flowner->address.', '.$flowner->city.', '.$flowner->zip_code.', '.$flowner->country}}</label><br>
        </td>
        @endif
        @if(App\User::find($shipment->shipper_id))
        <td style="border:1px solid; padding: 10px 15px">
          <b style="border-bottom:1px solid">Shipper Information:</b>
          <?php $shipper = App\User::find($shipment->shipper_id); ?>
          <label><b>Name:</b> {{$shipper->first_name.' '.$shipper->last_name}}</label><br>
          <label><b>Contact:</b> +{{$shipper->contact}}</label><br>
          <label><b>Email:</b> {{$shipper->email}}</label><br>
          <label><b>Address:</b> {{$shipper->address.', '.$shipper->city.', '.$shipper->zip_code.', '.$shipper->country}}</label><br>
        </td>
        @endif
      </tr>
      <tr>
        @if(App\User::find($shipment->dispatcher_id))
        <td style="border:1px solid; padding: 10px 15px">
          <b style="border-bottom:1px solid">Dispatcher Information:</b>
          <?php $dispatcher = App\User::find($shipment->dispatcher_id); ?>
          <label><b>Name:</b> {{$dispatcher->first_name.' '.$dispatcher->last_name}}</label><br>
          <label><b>Contact:</b> +{{$dispatcher->contact}}</label><br>
          <label><b>Email:</b> {{$dispatcher->email}}</label><br>
          <label><b>Address:</b> {{$dispatcher->address.', '.$dispatcher->city.', '.$dispatcher->zip_code.', '.$dispatcher->country}}</label><br>
        </td>
        @endif
        @if(App\User::find($shipment->driver_id))
        <td style="border:1px solid; padding: 10px 15px">
          <b style="border-bottom:1px solid">Driver Information:</b>
          <?php $driver = App\User::find($shipment->driver_id); ?>
          <label><b>Name:</b> {{$driver->first_name.' '.$driver->last_name}}</label><br>
          <label><b>Contact:</b> +{{$driver->contact}}</label><br>
          <label><b>Email:</b> {{$driver->email}}</label><br>
          <label><b>Address:</b> {{$driver->address.', '.$driver->city.', '.$driver->zip_code.', '.$driver->country}}</label><br>
        </td>
        @endif
      </tr>
    </table>
    <br>
    <table style="width:100%">
      <tr>
        <td>
          <b>Load Information</b>
          <label><b>Load Point: </b> {{$shipment->loading_point}}</label><br>
          <label><b>Load Date: </b> {{$shipment->loading_date?date('d M Y', strtotime($shipment->loading_date)):''}}</label><br>
          <label><b>Load Time: </b> {{$shipment->loading_time?date('h:i A', strtotime($shipment->loading_time)):''}} </label><br>
        </td>
        <td>
          <b>Unload Information</b>
          <label><b>Unload Point: </b> {{$shipment->unload_point}}</label><br>
          {{-- <label><b>Unload Date: </b> {{$shipment->unload_date?date('d M Y', strtotime($shipment->unload_date)):''}}</label><br> --}}
          {{-- <label><b>Unload Time: </b> {{$shipment->unload_time?date('h:i A', strtotime($shipment->unload_time)):''}} </label><br> --}}
        </td>
      </tr>
        <tr>
          <td style="vertical-align:top">
            <h4>Goods Description</h4>
            <label><b>Packing Type: </b> {{$shipment->packing_type}}</label><br>
            <label><b>Flammable?: </b> {{$shipment->flame == 'Flammable'?'Yes':'No'}}</label><br>
            <label><b>Load Quantity(tons): </b> {{$shipment->load_quantity}} </label><br>
          </td>
          <td>
            <h4>Shipment Cost Details</h4>
            <label><b>Shipment Cost: </b>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</label><br>
            <label><b>Extra Charge: </b>{{$shipment->extra_charge?'$'.number_format($shipment->extra_charge, 2):''}}</label><br>
            <label><b>Total Cost: </b>${{number_format($shipment->shipment_cost+$shipment->extra_charge, 2)}} </label><br>
          </td>
        </tr>
        <tr>
          <td>
            <h4>Vehicle Details</h4>
            <b>Starting Gas:</b> {{$shipment->starting_gas}}<br>
            <label><b>Vehicle License Plate: </b>
              @if(DB::table('vehicles')->find($shipment->vehicle_id))
              {{DB::table('vehicles')->find($shipment->vehicle_id)->license_plate}}
              @endif
            </label><br>
            <label><b>Start Mileage:</b> {{$shipment->start_mileage}}</label><br>
            <label><b>End Mileage:</b> {{$shipment->end_mileage}}</label><br>
          </td>
          <?php
          function timecalc($dt1, $dt2){
            $date1 = new DateTime($dt1);
            return $date1->diff(new DateTime($dt2));
          }
          ?>
          <td style="vertical-align:top">
            <h4>Route & Other</h4>
            <label><b>Extra Load Time: </b>
              @if(!empty($shipment->arrived_load_point) && !empty($shipment->load_complete_time))
              <?php $timecalc = timecalc($shipment->arrived_load_point, $shipment->load_complete_time); ?>
              {{($timecalc->h-2).'hours, '.$timecalc->m.'minutes'}}
              @endif
            </label><br>
            <label><b>Actual Distance: </b> {{$shipment->start_mileage-$shipment->end_mileage}} </label><br>
            <b>Total Distance:</b> {{$shipment->distance}}<br>
            <b>Duration:</b> {{$shipment->duration}}<br>
          </td>
        </tr>
        <tr>
          <td>
            <h4>Others</h4>
            <b>Status:</b>            
              @if($shipment->status == 0)
              <span class="label label-default"> Initiated </span>
              @elseif($shipment->status == 1)
              <span class="label label-primary"> Pick up Confirmed </span>
              @elseif($shipment->status == 2)
              <span class="label label-warning"> In Transit </span>
              @elseif($shipment->status == 3)
              <span class="label label-info"> Delivered </span>
              @elseif($shipment->status == 4)
              <span class="label label-success"> Completed </span>
              @elseif($shipment->status == 5)
              <span class="label label-danger"> Cancelled </span>
              @endif
              <br>
              <b>Comment:</b> {{$shipment->details}}<br>
          </td>
        </tr>
      </table>
  </div>
  
</body>
</html>