@extends('user')
@section('title', 'Financial Details')
@section('content')

<?php $user = Auth::user(); ?>

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Financial Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active"> Financial Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Financial Activities</h3>

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
                  <th>Fleet Owner</th>
                  @if($user->user_role != 'Shipper')
                  <th>Shipper</th>
                  @endif
                  <th>Loading Point</th>
                  <th>Unload Point</th>
                  <th titile="Shipment Cost">Cost</th>
                  @if($user->user_role == 'Driver' || $user->user_role == 'Dispatcher')
                  <th>Commission Earned</th>
                  @else
                  <th>Extra Charge</th>
                  @endif
                  <th>Shipment Status</th>
                  <th>Created On</th>
                </tr>

                <?php $total_costs = 0; ?>

                @foreach($shipments as $shipment)
                <?php $total_costs += $shipment->shipment_cost; ?>

                <tr>
                  <td>{{$shipment->id}}</td>
                  <td>
                    @if(App\User::find($shipment->fleetowner_id))
                    <?php $fleetowner = App\User::find($shipment->fleetowner_id); ?>
                    {{$fleetowner->first_name.' '.$fleetowner->last_name}}
                    @endif
                  </td>
                  @if($user->user_role != 'Shipper')
                  <td>
                    @if(App\User::find($shipment->shipper_id))
                    <?php $shipper = App\User::find($shipment->shipper_id); ?>
                    {{$shipper->first_name.' '.$shipper->last_name}}
                    @endif
                  </td>
                  @endif
                  <td>{{$shipment->loading_point}}</td>
                  <td>{{$shipment->unload_point}}</td>
                  <td>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</td>
                  @if($user->user_role == 'Driver')
                  <td>{{$shipment->driver_commission > 0?'$'.number_format($shipment->driver_commission, 2):''}}</td>
                  @elseif($user->user_role == 'Dispatcher')
                  <td>{{$shipment->dispatcher_commission > 0?'$'.number_format($shipment->dispatcher_commission, 2):''}}</td>
                  @else
                  <td>{{$shipment->extra_charge > 0?'$'.number_format($shipment->extra_charge, 2):''}}</td>
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
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$shipsearch->links()}} --}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->

@endsection