@extends('user')
@section('title', 'Shipments Reports')
@section('content')

<?php
  $user = Auth::user();

  $initiated = $pickup = $intransit = $delivered = $completed = $cancelled = 0;
  foreach ($shipments as $shipment) {
    if($shipment->status == 0){
      $initiated ++; 
    }elseif($shipment->status == 1){
      $pickup ++;
    }elseif($shipment->status == 2){
      $intransit ++;
    }elseif($shipment->status == 3){
      $delivered ++;
    }elseif($shipment->status == 4){
      $completed ++;
    }elseif($shipment->status == 5){
      $cancelled ++;
    }
  }
?>

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Shipment Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active"> Shipments</li>
      </ol>
    </section>
    <br>

    <style type="text/css">
    .reports .box-body{font-size: 25px;font-weight: bold;text-align: center;}
    /*.reports{max-width: 200px;}*/
    .reports .box-title{font-size: 16px}
    </style>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Shipment Initiated</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$initiated}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Ready for Pick up</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$pickup}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">In Transit</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$intransit}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-info box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Delivered</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$delivered}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->
        
        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Completed</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$completed}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Cancelled</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">{{$cancelled}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->
      </div>
      <!-- /.row -->


      <div class="row">
        <div class="col-md-6">
          <div class="box">
            {!! Form::open(['route' => 'reports.shipment', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
              <h4 class="box-title">Search Shipment Reports</h4>
                <div class="col-md-5">
                  <div class="form-group">
                    {{ Form::label('start_date', 'Start Date:', ['class' => 'control-label']) }}
                    {{ Form::text('start_date', date('m/d/Y', strtotime('-1 days')), ['class' => 'form-control datepicker','required'=>'required'])}}
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    {{ Form::label('end_date', 'End Date:', ['class' => 'control-label']) }}
                    {{ Form::text('end_date', date('m/d/Y'), ['class' => 'form-control datepicker', 'required'=>'required'])}}
                  </div>
                </div>
                <div class="col-md-2"><br>
                  <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Submit</button>
                </div>

              </div>
              <!-- /.box-body -->
            {!! Form::close() !!}
          </div>
        </div>

        @if(count($shipsearches) > 0)
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
                  @if($user->user_role != 'Fleet Owner')
                  <th>Fleet Owner</th>
                  @endif
                  @if($user->user_role != 'Shipper')
                  <th>Shipper</th>
                  @endif
                  @if($user->user_role != 'Driver')
                  <th>Driver</th>
                  @endif
                  @if($user->user_role != 'Dispatcher')
                  <th>Dispatcher</th>
                  @endif
                  <th>Loading Point</th>
                  <th>Unload Point</th>
                  <th title="Shipment Cost">Cost</th>
                  <th>Extra Charge</th>
                  <th>Status</th>
                  <th>Created On</th>
                  {{-- <th width="90">Actions</th> --}}
                </tr>

                <?php $total_costs = 0; ?>

                @foreach($shipsearches as $shipment)
                <?php $total_costs += $shipment->shipment_cost; ?>

                <tr>
                  <td>{{$shipment->id}}</td>
                  @if($user->user_role != 'Fleet Owner')
                  <td>
                    @if(App\User::find($shipment->fleetowner_id))
                    <?php $fleetowner = App\User::find($shipment->fleetowner_id); ?>
                    {{$fleetowner->first_name.' '.$fleetowner->last_name}}
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
                  @if($user->user_role != 'Driver')
                  <td>
                    @if(App\User::find($shipment->driver_id))
                    <?php $driver = App\User::find($shipment->driver_id); ?>
                    {{$driver->first_name.' '.$driver->last_name}}
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
                  <td>{{$shipment->loading_point}}</td>
                  <td>{{$shipment->unload_point}}</td>
                  <td>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</td>
                  <td>{{$shipment->extra_charge?'$'.number_format($shipment->extra_charge, 2):''}}</td>
                  <td>
                    @if($shipment->status == 0)
                    <span class="text-warning">Process Initiated</span>
                    @elseif($shipment->status == 1)
                    <span class="text-success">In Transit</span>
                    @elseif($shipment->status == 2)
                    <span class="text-info">Completed</span>
                    @else
                    <span class="text-danger">Cancelled</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="9" class="text-right">Total Cost: {{$total_costs?'$'.number_format($total_costs, 2):''}}</th>
                </tr>
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
        @endif
      </div>
    </section> <!-- /.content -->

@endsection