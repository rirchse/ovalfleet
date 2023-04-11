@extends('user')
@section('title', 'Shipment Details')
@section('content')
<?php $user = Auth::user(); ?>
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
            <h4>Shipment Details By {{App\User::find($shipment->user_id)->user_role}}</h4>
          </div>
          <div class="col-md-8 text-right toolbar-icon">
              <a href="/shipment/{{$shipment->id}}/expense/driver" title="Shipment Expenses" class="label label-primary"><i class="fa fa-money"></i></a>
              <a href="/active/shipments/driver" title="Veiw Active Shipments" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="/shipment/{{$shipment->id}}/print" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
              <a href="/shipment/driver/{{$shipment->id}}/edit" class="label label-warning" title="Edit shipment"><i class="fa fa-edit"></i></a>
          </div>
                <div class="col-md-6 userbox">
                  @if(!empty($shipment->shipper_id))
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
                    @if(!empty($shipment->dispatcher_id))
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
                    @if(!empty($shipment->user_id))
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
                    @if(!empty($shipment->driver_id))
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
                          <th>Packaging Type:</th>
                          <td>{{$shipment->packing_type}}</td>
                        </tr>
                        <tr>
                          <th>Flammable?</th>
                          <td>{{$shipment->flame == 'Flammable'?'Yes':'No'}}</td>
                        </tr>
                        <tr>
                          <th>Loading Point:</th>
                          <td>{{$shipment->loading_point}}<input type="hidden" name="loading_point" id="loading_point" value="{{$shipment->loading_point}}"></td>
                        </tr>
                        <tr>
                          <th>Unload Point:</th>
                          <td>{{$shipment->unload_point}}<input type="hidden" name="unload_point" id="unload_point" value="{{$shipment->unload_point}}"></td>
                        </tr>
                        <tr>
                          <th>Loading Date:</th>
                          <td>{{date('d M Y', strtotime($shipment->loading_date))}}</td>
                        </tr>
                        <tr>
                          <th>Unload Date:</th>
                          <td>{{date('d M Y', strtotime($shipment->unload_date))}}</td>
                        </tr>
                        <tr>
                          <th>Loading Time:</th>
                          <td>{{date('h:i A', strtotime($shipment->loading_time))}}</td>
                        </tr>
                        <tr>
                          <th>Unload Time:</th>
                          <td>{{date('h:i A', strtotime($shipment->unload_time))}}</td>
                        </tr>
                         {{-- <tr>
                          <th>Shipment Cost:</th>
                          <td>{{$shipment->shipment_cost?'$'.$shipment->shipment_cost:''}}</td>
                        </tr> --}}
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
                        {{-- <tr>
                          <th>Starting Gas</th>
                          <td>{{$shipment->starting_gas}}</td>
                        </tr> --}}
                        {{-- <tr>
                          <th>Location Distance Measurement:</th>
                          <td>{{$shipment->location_distance}}</td>
                        </tr> --}}
                        {{-- <tr>
                          <th>Actual Distance:</th>
                          <td>{{$shipment->actual_distance}}</td>
                        </tr> --}}
                        <tr>
                          <th>Total Distance:</th>
                          <td>{{$shipment->distance}}</td>
                        </tr>
                        <tr>
                          <th>Duration:</th>
                          <td>{{$shipment->duration}}</td>
                        </tr>
                        {{-- <tr>
                          <th>Extra Charge:</th>
                          <td>{{$shipment->extra_charge}}</td>
                        </tr> --}}
                        {{-- <tr>
                          <th>Dispatcher Commission:</th>
                          <td>{{$shipment->dispatcher_commission?'$'.$shipment->dispatcher_commission:''}}</td>
                        </tr>
                        <tr>
                          <th>Driver Commission:</th>
                          <td>{{$shipment->driver_commission?'$'.$shipment->driver_commission:''}}</td>
                        </tr> --}}
                        <tr>
                          <th>Status:</th>
                          <td>
                            @if($shipment->status == 0)
                            <span class="label-primary"> &nbsp; Shipment process initiated &nbsp;</span>
                            @elseif($shipment->status == 1)
                            <span class="label-success"> &nbsp; Shipment in Transit &nbsp;</span>
                            @elseif($shipment->status == 2)
                            <span class="label-info"> &nbsp; Shipment Completed &nbsp;</span>
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
                        <tr>
                          <th>Updated by:</th>
                          <td>
                            @if(App\User::find($shipment->updated_by))
                            <?php $updatedby = App\User::find($shipment->updated_by); ?>
                            {{$updatedby->first_name.' '.$updatedby->last_name}}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>
                            <label class="control-label" for="">Google Map Route</label><br>
                          </th>
                          <td>
                            @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                            <button type="button" class="btn btn-info btn-block" onclick="calcRoute()"><i class="fa fa-map-marker"></i> Get Route information</button>
                            @else
                            <a class="btn btn-info btn-block" href="#" onclick="GetFreeRoute()"> Get Route information</a>
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

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsrrM_cjLyueDaFj3qvLwU0KF7ME2TIg&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--script src="/js/jquery-3.1.1.min.js"></script-->
    <script src="/js/map.js"></script>
   
@endsection