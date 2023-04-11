@extends('user')
@section('title', 'Vehicle List')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Vehicles</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vehicles</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active"> View Vehicle</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Vehicles</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            {{-- <div class="row">
              <div class="col-md-5 col-md-offset-10">
                   <a href="/view_vehicles" title="Vehicle Details" class="label label-success"><i class="fa fa-list"></i></a>
                    <a href="/view_vehicles" title="Vehicle Details" class="label label-info"><i class="fa fa-print"></i></a>
              </div>
              
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Fleet Owner</th>
                  <th>License Plate</th>
                  <th>VIN/SN</th>
                  <th>Vehicle Name/Type</th>
                  <th>Color</th>
                  <th>Capacity</th>
                  <th>Purchase Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>
                @foreach($fleetowners as $fleetowner)

                @foreach(App\Vehicle::where('user_id', $fleetowner->owner_id)->get() as $vehicle)
                <?php
                 $r++; 
                 $user = App\User::find($vehicle->user_id);
                ?>

                <tr>
                  <td>{{$user->first_name.' '.$user->last_name}}</td>
                  <td>{{$vehicle->license_plate}}</td>
                  <td>{{$vehicle->vinsn}}</td>
                  <td>{{$vehicle->name_type}}</td>
                  <td>{{$vehicle->color}}</td>
                  <td>{{$vehicle->capacity}}</td>
                  <td>{{$vehicle->purchase_date? date('d M Y', strtotime($vehicle->purchase_date)):''}}</td>
                  <td>{{$vehicle->vehicle_status}}</td>
                  <td>
                    {{-- <a href="/vehicle/{{$vehicle->id}}/details" title="Vehicle Details" class="label label-info"><i class="fa fa-file-text"></i></a> --}}
                    {{-- <a href="/vehicle/{{$vehicle->id}}/edit" class="label label-warning" title="Edit Vehicle"><i class="fa fa-edit"></i></a>
                    <a href="/vehicle/{{$vehicle->id}}/delete" class="label label-danger" title="Delete Vehicle" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fa fa-trash"></i></a> --}}
                    {{-- <a href="#">Add Expenses</a> --}}
                  </td>
                </tr>
                @endforeach
                @endforeach <!-- fleet owners loop -->
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <div class="pagination-sm no-margin pull-right">
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection