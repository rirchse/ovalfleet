@extends('user')
@section('title', 'Shipment Associated Details')
@section('content')
<?php $user = Auth::user(); ?>
<style type="text/css">
  .userbox{min-height: 160px;border:1px solid #ddd;}
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
            <h4>Shipment Details By {{App\User::find($shipment->user_id)->user_role}}</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              <a href="/view_associated_shipments/{{$shipment->user_id}}" title="View Associated Shipments" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="/shipment/{{$shipment->id}}/print" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
              <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning" title="Edit shipment"><i class="fa fa-edit"></i></a> --}}
              {{-- <a href="/shipment/{{$shipment->id}}/delete" class="label label-danger" title="Delete shipment" onclick="return confirm('Are you sure you want to delete this shipment?');"><i class="fa fa-trash"></i></a> --}}
          </div>
                @if(App\User::find($shipment->fleetowner_id))
                  <div class="col-md-6 userbox">
                    <table class="table">
                    <?php $user_fleetowner = App\User::find($shipment->fleetowner_id); ?>
                      <tbody>
                        <tr>
                          <th>Fleet Owner:</th>
                          <td>{{ $user_fleetowner->first_name.' '.$user_fleetowner->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Fleet Owner Contact:</th>
                          <td>{{ $user_fleetowner->contact}}</td>
                        </tr>
                        <tr>
                          <th>Last status update:</th>
                          <td>
                            {{ $shipment->created_by == $user_fleetowner->id?' Created':''}}
                            {{ $shipment->updated_by == $user_fleetowner->id?' Updated':''}}
                            {{ $shipment->confirm_by == $user_fleetowner->id?' Confirmed':''}}
                            {{ $shipment->complete_by == $user_fleetowner->id?' Completed':'' }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                @endif

                @if(App\User::find($shipment->shipper_id))
                <div class="col-md-6 userbox">
                  <table class="table">
                    <?php $user_shipper = App\User::find($shipment->shipper_id); ?>
                      <tbody>
                        <tr>
                          <th>Shipper:</th>
                          <td>{{ $user_shipper->first_name.' '.$user_shipper->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Shipper Contact:</th>
                          <td>{{ $user_shipper->contact}}</td>
                        </tr>
                        <tr>
                          <th>Last status update:</th>
                          <td>
                            {{ $shipment->created_by == $user_shipper->id?' Created':''}}
                            {{ $shipment->updated_by == $user_shipper->id?' Updated':''}}
                            {{ $shipment->confirm_by == $user_shipper->id?' Confirmed':''}}
                            {{ $shipment->complete_by == $user_shipper->id?' Completed':'' }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  @endif

                  @if(App\User::find($shipment->dispatcher_id))
                  <div class="col-md-6 userbox">
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
                        <tr>
                          <th>Last status update:</th>
                          <td>
                            {{ $shipment->created_by == $user_dispatcher->id?' Created':''}}
                            {{ $shipment->updated_by == $user_dispatcher->id?' Updated':''}}
                            {{ $shipment->confirm_by == $user_dispatcher->id?' Confirmed':''}}
                            {{ $shipment->complete_by == $user_dispatcher->id?' Completed':'' }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  @endif

                  @if(App\User::find($shipment->driver_id))
                  <div class="col-md-6 userbox">
                    <table class="table">
                    <?php $user_driver = App\User::find($shipment->driver_id); ?>
                      <tbody>
                        <tr>
                          <th>Driver:</th>
                          <td>{{ $user_driver->first_name.' '.$user_driver->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Driver Contact:</th>
                          <td>{{ $user_driver->contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                  </div>
                  @endif

                  <div class="clearfix"></div>

                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th>Packaging Type:</th>
                          <td>{{$shipment->packing_type}}</td>
                        </tr>
                        <tr>
                          <th>Flammable?</th>
                          <td>{{$shipment->flame == 'Flammable'?'Yes':'No'}}</td>
                        </tr>
                        <tr>
                          <th>Origin:</th>
                          <td>{{$shipment->loading_point}}<input type="hidden" name="loading_point" id="loading_point" value="{{$shipment->loading_point}}"></td>
                        </tr>
                        <tr>
                          <th>Destination:</th>
                          <td>{{$shipment->unload_point}}<input type="hidden" name="unload_point" id="unload_point" value="{{$shipment->unload_point}}"></td>
                        </tr>
                        <tr>
                          <th>Loading Date & Time:</th>
                          <td>{{date('d M Y ', strtotime($shipment->loading_date))}} {{date(' h:i A', strtotime($shipment->loading_time))}}</td>
                        </tr>
                        <tr>
                          <th>Unload Date & Time:</th>
                          <td>{{date('d M Y ', strtotime($shipment->unload_date))}} {{date(' h:i A', strtotime($shipment->unload_time))}}</td>
                        </tr>
                         <tr>
                          <th>Shipment Cost:</th>
                          <td>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</td>
                        </tr>
                        <tr>
                          <th>Extra Charge:</th>
                          <td>{{$shipment->extra_charge?'$'.number_format($shipment->extra_charge, 2):''}}</td>
                        </tr>
                         <tr>
                          <th>Load Quantity(tons):</th>
                          <td>{{$shipment->load_quantity}}</td>
                        </tr>
                        {{-- <tr>
                          <th>Start Mileage</th>
                          <td>{{$shipment->start_mileage}}</td>
                        </tr>
                        <tr>
                          <th>End Mileage</th>
                          <td>{{$shipment->end_mileage}}</td>
                        </tr> --}}
                        <tr>
                          <th>Vehicle License Plate:</th>
                          <td>
                            @if(DB::table('vehicles')->find($shipment->vehicle_id))
                            {{DB::table('vehicles')->find($shipment->vehicle_id)->license_plate}}
                            @endif
                          </td>
                        </tr>
                        
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                        <?php
                        function timecalc($dt1, $dt2){
                          $date1 = new DateTime($dt1);
                          return $date1->diff(new DateTime($dt2));
                        }
                        ?>
                        <tr>
                          <th>Extra Load Time: <span class="label label-info" style="cursor:pointer; font-size:12px" onclick="alert('Extra Load Time = Total number of hours needed to load the truck - detention time ( 2 hours)')">?</span></th>
                          <td>
                            @if(!empty($shipment->arrived_load_point) && !empty($shipment->load_complete_time))
                            <?php $timecalc = timecalc($shipment->arrived_load_point, $shipment->load_complete_time); ?>
                            {{($timecalc->h-2).'hours, '.$timecalc->m.'minutes'}}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Actual Distance (miles):</th>
                          <td>
                            @if(!empty($shipment->end_mileage) && !empty($shipment->start_mileage))
                            {{$shipment->end_mileage - $shipment->start_mileage}}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Total Distance:</th>
                          <td>{{$shipment->distance}}</td>
                        </tr>
                        <tr>
                          <th>Duration:</th>
                          <td>{{$shipment->duration}}</td>
                        </tr>
                        @if($user->user_role != 'Driver')
                        <tr>
                          <th>Dispatcher Commission:</th>
                          <td>{{$shipment->dispatcher_commission?'$'.number_format($shipment->dispatcher_commission, 2):''}}</td>
                        </tr>
                        @endif
                        @if($user->user_role != 'Dispatcher')
                        <tr>
                          <th>Driver Commission:</th>
                          <td>{{$shipment->driver_commission?'$'.number_format($shipment->driver_commission, 2):''}}</td>
                        </tr>
                        @endif
                        <tr>
                          <th>Shipment Status:</th>
                          <td style="font-size: 18px;font-weight:normal">
                            @if($shipment->status == 0)
                            <span class="label label-default"> Initiated </span>
                            @elseif($shipment->status == 1)
                            <span class="label label-primary"> Pickup Confirmed </span>
                            @elseif($shipment->status == 2)
                            <span class="label label-warning"> In Transit </span>
                            @elseif($shipment->status == 3)
                            <span class="label label-info"> Delivered </span>
                            @elseif($shipment->status == 4)
                            <span class="label label-success"> Completed </span>
                            @elseif($shipment->status == 5)
                            <span class="label label-danger"> Cancelled </span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Comment:</th>
                          <td>{{$shipment->details}}</td>
                        </tr>
                        <tr>
                          <th>Record Created On:</th>
                          <td>{{date('d M Y h:i ',strtotime($shipment->created_at) )}} </td>
                        </tr>
                        <tr>
                          <th>Updated by:</th>
                          <td>
                            @if(App\User::find($shipment->updated_by))
                            <?php $updatedby = App\User::find($shipment->updated_by); ?>
                            {{$updatedby->first_name.' '.$updatedby->last_name}}
                            @endif
                          </td>
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