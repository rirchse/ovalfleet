@extends('user')
@section('title', 'Shipment Details')
@section('content')
<?php $user = Auth::user(); ?>
<style type="text/css">
  .userbox{ min-height: 130px;border:1px solid #ddd; }
  .userbox table{margin-bottom: 0;}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Shipment Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipments</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-11"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>Shipment Information:</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <small style="float:left;margin-top:5px;font-size:18px">
              Shipment Status: 
            @if($shipment->status == 0)
            <span class="text-default"> Initiated </span>
            @elseif($shipment->status == 1)
            <span class="text-primary"> Pick up Confirmed </span>
            @elseif($shipment->status == 2)
            <span class="text-warning"> In Transit </span>
            @elseif($shipment->status == 3)
            <span class="text-info"> Delivered </span>
            @elseif($shipment->status == 4)
            <span class="text-success"> Completed </span>
            @elseif($shipment->status == 5)
            <span class="text-danger"> Cancelled </span>
            @endif
            @if($user->user_role != 'Driver' && $shipment->status != 4) &nbsp; 
            <a href="#" data-target="#modal-default" data-toggle="modal" class="label label-primary"> Update</a>
            @endif

            </small>
            @if($user->user_role != 'Shipper')
            @if($shipment->status > 0 && $shipment->status < 3)
            <a href="/create_shipment/{{$shipment->id}}/expense" class="label label-info" title="Add Shipment Expense"><i class="fa fa-plus"></i></a>
            @endif
            @endif
            @if($user->user_role == "Driver")
              @if($shipment->status != 4)
              <a href="/shipment/driver/{{$shipment->id}}/edit" class="label label-warning" title="Update Shipment"><i class="fa fa-edit"></i></a>
              @endif
            @endif
            @if($user->user_role != 'Shipper')
            <a href="/view_shipment/{{$shipment->id}}/expenses" title="View Shipment Expenses" class="label label-primary"><i class="fa fa-usd"></i></a>
            @endif
            <a href="/view_shipments" title="All Shipments" class="label label-success"><i class="fa fa-list"></i></a>
            @if($user->user_role != 'Driver')
            <a target="_blank" href="/shipment/{{$shipment->id}}/pdf" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
            @endif
            @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
              @if($shipment->status != 4 || $user->user_role == 'Fleet Owner')
              <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning" title="Update Shipment"><i class="fa fa-edit"></i></a>
              @endif
            @endif
              
            @if($user->user_role == 'Fleet Owner')
              @if($shipment->status == 0)
              <a href="/shipment/{{$shipment->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure you want to delete this shipment?');" title="Delete Shipment"><i class="fa fa-trash"></i></a>
              @elseif($shipment->status == 1)
              <a href="/shipment/{{$shipment->id}}/cancel" class="label label-danger" onclick="return confirm('Are you sure you want to cancel this shipment?');" title="Cancel Shipment"><i class="fa fa-close"></i></a>
              @endif
            @endif

            </div>

                @if(App\User::find($shipment->fleetowner_id))
                  <div class="col-md-6 userbox" id="FleetOwner">
                    <table class="table">
                    <?php $user_fleetowner = App\User::find($shipment->fleetowner_id); ?>
                      <tbody>
                        <tr>
                          <th style="width:150px">Fleet Owner:</th>
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
                          <th style="width:150px">Shipper:</th>
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
                          <th style="width:150px">Dispatcher:</th>
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
                  @else
                  <div class="col-md-6 userbox" id="Dispatcher"></div>
                  <script type="text/javascript">
                  document.getElementById('Dispatcher').innerHTML = document.getElementById('FleetOwner').innerHTML;
                  </script>
                  @endif

                  @if(App\User::find($shipment->driver_id))
                  <div class="col-md-6 userbox">
                    <table class="table">
                    <?php $user_driver = App\User::find($shipment->driver_id); ?>
                      <tbody>
                        <tr>
                          <th style="width:150px">Driver:</th>
                          <td>{{ $user_driver->first_name.' '.$user_driver->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Driver Contact:</th>
                          <td>{{ $user_driver->contact }}</td>
                        </tr>
                        </tbody>
                    </table>
                  </div>
                  @else
                  <div class="col-md-6 userbox" id="Driver"></div>
                  <script type="text/javascript">
                  document.getElementById('Driver').innerHTML = document.getElementById('FleetOwner').innerHTML;
                  </script>
                  @endif

                  <div class="clearfix"></div>

                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th style="width:180px">Packaging Type:</th>
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
                        {{-- <tr>
                          <th>Unload Date & Time:</th>
                          <td>{{$shipment->unload_date?date('d M Y ', strtotime($shipment->unload_date)).' '.date(' h:i A', strtotime($shipment->unload_time)):''}}</td>
                        </tr> --}}
                        
                         <tr>
                          <th>Shipment Cost:</th>
                          <td>
                            @if($user->user_role != 'Driver')
                            {{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Extra Charge: 
                            @if($user->user_role != 'Driver')
                            <span style="cursor:pointer; font-size: 12px" class="label label-info" data-toggle="tooltip" title="(Additional expense that occurred in a shipment) : {!!$shipment->extra_charge_reason!!}">?</span>
                            @endif
                          </th>
                          <td>
                            @if($user->user_role != 'Driver')
                            {{$shipment->extra_charge?'$'.number_format($shipment->extra_charge, 2):''}}</td>
                            @endif
                        </tr>
                        <tr>
                          <th>Total Cost:</th>
                          <td>
                            @if($user->user_role != 'Driver')
                            ${{number_format($shipment->shipment_cost+$shipment->extra_charge, 2)}}
                            @endif
                          </td>
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
                          <th style="width:180px">Extra Load Time: <span class="label label-info" style="cursor:pointer; font-size:12px"  data-toggle="tooltip" title="Extra Load Time = Total number of hours needed to load the truck - detention time ( 2 hours)">?</span></th>
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
                        @if($user->user_role != 'Shipper')
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
                        @endif
                        <tr>
                          <th>Shipment Status:</th>
                          <td style="font-size: 18px;font-weight:normal">
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
                          </td>
                        </tr>
                        <tr>
                          <th>Comment:</th>
                          <td>{!!$shipment->details!!}</td>
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
                  <div class="col-md-12">
                    <table class="table">
                      <tr>
                        <th style="width:180px">Status Updated:</th>
                        <td colspan="3">{!!$shipment->confirm_note!!}</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                          <label class="control-label" for="">Google Map Route:</label><br>
                        </td>
                        <td style="max-width:110px">
                          @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                          <button type="button" class="btn btn-info btn-block" onclick="calcRoute()"><i class="fa fa-map-marker"></i> Get Route Information</button>
                          @else
                          <a class="btn btn-info btn-block" href="#" onclick="GetFreeRoute()"> Get Route Information</a>
                          @endif
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-12">
                    @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                    <div id="googleMap"></div><br>
                    @endif
                  </div>
                  <div class="clearfix"></div>
                </div>

              </div><!-- /.box -->
            </div><!--/.col (left) -->
        
        <!-- Shipment Confirmation Dialogue Box -->
            <div class="modal fade" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  {!! Form::model($shipment, ['route' => ['shipment.confirm', $shipment->id], 'method' => 'PUT', 'files' => true]) !!}
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Shipment Status</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                    <h4>
                      @if($shipment->status == 0)
                      <label><input type="checkbox" name="status" value="1"> Confirm pick up (PU) &nbsp;</label>
                      @endif
                      @if($shipment->status == 1)
                      <label><input type="radio" name="status" value="2"> In Transit &nbsp; </label>
                      <label><input type="radio" name="status" value="5"> Cancel &nbsp; </label>
                      @endif
                      @if($shipment->status == 2)
                      <label><input type="checkbox" name="status" value="3"> Delivered &nbsp; </label>
                      @endif
                      @if($shipment->status == 3)
                      <label><input type="checkbox" name="status" value="4"> Complete &nbsp; </label>
                      @endif
                      @if($shipment->status == 5)
                      <label><input type="checkbox" name="status" value="0"> Retrieve Shipment &nbsp; </label>
                      @endif
                    </h4>
                    </div>
                    <div class="form-group ">
                      {{ Form::label('confirm_note', 'Note:', ['class' => 'control-label']) }}
                      {{ Form::textarea('confirm_note', '', ['class' => 'form-control', 'rows'=>'3', 'placeholder'=>'Please write details here.', 'required'=>'']) }}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                  </div>
                  <div class="modal-body">
                    {!!$shipment->confirm_note!!}
                  </div>
                  {!! Form::close() !!}
                </div> <!-- /.modal-content -->
              </div> <!-- /.modal-dialog -->
            </div> <!-- /.modal -->

  </section><!-- /.content -->

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsrrM_cjLyueDaFj3qvLwU0KF7ME2TIg&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--script src="/js/jquery-3.1.1.min.js"></script-->
    <script src="/js/map.js"></script>

    <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
   
@endsection