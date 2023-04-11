@extends('user')
@section('title', 'Shipment Details')
@section('content')
<style type="text/css">
  .userbox{
    min-height: 160px;border:1px solid #ddd;
  }
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Shipment Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-11"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>Shipment Details By 
              @if(App\User::find($shipment->user_id)->user_role)
              {{App\User::find($shipment->user_id)->user_role}}
              @endif
            </h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              <a href="/view_shipments" title="All Shipments" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="/shipment/{{$shipment->id}}/print" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
              <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning" title="Edit shipment"><i class="fa fa-edit"></i></a>
              {{-- <a href="/shipment/{{$shipment->id}}/delete" class="label label-danger" title="Delete shipment" onclick="return confirm('Are you sure you want to delete this shipment?');"><i class="fa fa-trash"></i></a> --}}
          </div>
                <div class="col-md-6 userbox">
                  @if(App\User::find($shipment->shipper_id))
                  <table class="table">
                    <?php $user_shipper = App\User::find($shipment->shipper_id); ?>
                      <tbody>
                        <tr>
                          <th>Shipper:</th>
                          <td>{{ $user_shipper->first_name.' '.$user_shipper->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Shipper Contact :</th>
                          <td>{{ $user_shipper->contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
                  </div>
                  <div class="col-md-6 userbox">
                    @if(App\User::find($shipment->dispatcher_id))
                    <table class="table">
                    <?php $user_dispatcher = App\User::find($shipment->dispatcher_id); ?>
                      <tbody>
                        <tr>
                          <th>Dispatcher:</th>
                          <td>{{ $user_dispatcher->first_name.' '.$user_dispatcher->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Dispatcher Contact:</th>
                          <td>{{ $user_dispatcher->contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
                  </div>                  
                  <div class="col-md-6 userbox">
                    @if(App\User::find($shipment->user_id))
                    <table class="table">
                    <?php $user_fleetowner = App\User::find($shipment->user_id); ?>
                      <tbody>
                        <tr>
                          <th>Fleet Owner:</th>
                          <td>{{ $user_fleetowner->first_name.' '.$user_fleetowner->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Fleet Owner Contact :</th>
                          <td>{{ $user_fleetowner->contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
                  </div>

                  <div class="col-md-6 userbox">
                    @if(App\User::find($shipment->driver_id))
                    <table class="table">
                    <?php $user_driver = App\User::find($shipment->driver_id); ?>
                      <tbody>
                        <tr>
                          <th>Driver:</th>
                          <td>{{ $user_driver->first_name.' '.$user_driver->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Driver Contact :</th>
                          <td>{{ $user_driver->contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                    @endif
                  </div>
                  {{-- </div> --}}
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
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
                         <tr>
                          <th>Shipment Cost:</th>
                          <td>${{number_format($shipment->shipment_cost)}}</td>
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
                        
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
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
                          <td>${{number_format($shipment->extra_charge, 2)}}</td>
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
                          <td>{{date('d M Y h:i A',strtotime($shipment->created_at) )}} </td>
                        </tr>          
                      </tbody>
                    </table>

                  </div>
                  <div class="clearfix"></div>
                </div>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection