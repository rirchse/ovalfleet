@extends('user')
@section('title', 'View Shipments')
@section('content')

<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Shipments Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Shipments</li>
      </ol>
    </section>
    <br>

        <div class="col-md-6">
          <div class="box">
            {!! Form::open(['route' => 'reports.shipment', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('start_date', 'Beginning Date:', ['class' => 'control-label']) }}
                    {{ Form::date('start_date', null, ['class' => 'form-control', 'required'=>'required'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('end_date', 'End Date:', ['class' => 'control-label']) }}
                    {{ Form::date('end_date', null, ['class' => 'form-control', 'required'=>'required'])}}
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Submit</button>
              </div>
            {!! Form::close() !!}
          </div>
        </div>

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
                  <th>Shipment Cost (in USD)</th>
                  <th>Status</th>
                  <th>Created On</th>
                  {{-- <th width="90">Actions</th> --}}
                </tr>

                <?php $total_costs = 0; ?>

                @foreach($shipments as $shipment)
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
                  <td>${{$shipment->shipment_cost}}</td>
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
                  <td>
                    {{-- <a href="/shipment/{{ $shipment->id }}/details" class="label label-info" title="View Details"><i class="fa fa-file-text"></i></a> --}}
                    @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                    {{-- <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning" title="Edit Shipment"><i class="fa fa-edit"></i></a> --}}
                    @endif
                    @if($user->user_role == 'Fleet Owner')
                    {{-- <a href="/shipment/{{$shipment->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure you want to delete this shipment?');" title="Delete Shipment"><i class="fa fa-trash"></i></a> --}}
                    @endif
                  </td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="9" class="text-right">Total Costs: ${{$total_costs}}</th>
                </tr>
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