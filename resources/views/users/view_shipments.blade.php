@extends('user')
@section('title', 'View Shipments')
@section('content')

<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View All Shipments</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Shipments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Shipments</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Created On</th>
                  @if($user->user_role != 'Fleet Owner')
                  <th>Fleet Owner</th>
                  @endif
                  @if($user->user_role != 'Dispatcher')
                  <th>Dispatcher</th>
                  @endif
                  @if($user->user_role != 'Driver')
                  <th>Driver</th>
                  @endif
                  @if($user->user_role != 'Shipper')
                  <th>Shipper</th>
                  @endif
                  <th title="License Plate No.">Vehicle(LP)</th>
                  <th>Loading Point</th>
                  <th>Unload Point</th>
                  @if($user->user_role != 'Driver')
                  <th title="Shipment Cost">Cost</th>
                  <th>Extra Charge</th>
                  @endif
                  <th title="Shipment Status">Status</th>
                  <th width="90">Action</th>
                </tr>

                @foreach($shipments as $shipment)

                <tr>
                  <td>{{$shipment->id}}</td>
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
                  @if($user->user_role != 'Fleet Owner')
                  <td>
                    @if(App\User::find($shipment->fleetowner_id))
                    <?php $fleetowner = App\User::find($shipment->fleetowner_id); ?>
                    {{$fleetowner->first_name.' '.$fleetowner->last_name}}
                    @endif
                  </td>
                  @endif
                  @if($user->user_role != 'Dispatcher')
                  <td>
                    @if(App\User::find($shipment->dispatcher_id))
                    <?php $dispatcher = App\User::find($shipment->dispatcher_id); ?>
                    {{$dispatcher->first_name.' '.$dispatcher->last_name}}
                    @endif
                  </td>
                  @endif
                  @if($user->user_role != 'Driver')
                  <td>
                    @if(App\User::find($shipment->driver_id))
                    <?php $driver = App\User::find($shipment->driver_id); ?>
                    {{$driver->first_name.' '.$driver->last_name}}
                    @endif
                  </td>
                  @endif
                  @if($user->user_role != 'Shipper')
                  <td>
                    @if(App\User::find($shipment->shipper_id))
                    <?php $shipper = App\User::find($shipment->shipper_id); ?>
                    {{$shipper->first_name.' '.$shipper->last_name}}
                    @endif
                  </td>
                  @endif
                  <td>{{$shipment->vehicle_id?App\Vehicle::find($shipment->vehicle_id)->license_plate:''}}</td>
                  <td>{{$shipment->loading_point}}</td>
                  <td>{{$shipment->unload_point}}</td>
                  @if($user->user_role != 'Driver')
                  <td>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</td>
                  <td>{{$shipment->extra_charge?'$'.number_format($shipment->extra_charge, 2):''}}</td>
                  @endif
                  <td>
                    @if($shipment->status == 0)
                    <span class="text-default">Initiated</span>
                    @elseif($shipment->status == 1)
                    <span class="text-primary">Pick up Confirmed</span>
                    @elseif($shipment->status == 2)
                    <span class="text-warning">In Transit</span>
                    @elseif($shipment->status == 3)                    
                    <span class="text-info">Delivered</span>
                    @elseif($shipment->status == 4)
                    <span class="text-success">Completed</span>
                    @elseif($shipment->status == 5)
                    <span class="text-danger">Cancelled</span>
                    @endif
                  </td>
                  <td>
                    <a href="/shipment/{{ $shipment->id }}/details" class="label label-info" title="View Details"><i class="fa fa-file-text"></i></a>
                    @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                      @if($shipment->status != 4 || $user->user_role == 'Fleet Owner')
                      <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning" title="Edit Shipment"><i class="fa fa-edit"></i></a>
                      @endif
                    @endif
                    @if($user->user_role != 'Shipper')
                    <a href="/view_shipment/{{$shipment->id}}/expenses" title="View Shipment Expenses" class="label label-primary"><i class="fa fa-usd"></i></a>
                    @endif
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$shipments->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection