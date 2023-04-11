@extends('admin')
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
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Fleet Owner</th>
                  <th>License Plate</th>
                  <th>Vehicle Name/Type</th>
                  <th>Color</th>
                  <th>Capacity(tons)</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($vehicles as $vehicle)
                <?php $r++; ?>

                <tr>
                  <td>
                    @if(App\User::find($vehicle->user_id))
                    <?php
                    $fleetwoner = App\User::find($vehicle->user_id);
                    ?>
                    {{$fleetwoner->first_name.' '.$fleetwoner->last_name}}
                    @endif
                  </td>
                  <td>{{$vehicle->license_plate}}</td>
                  <td>{{$vehicle->name_type}}</td>
                  <td>{{$vehicle->color}}</td>
                  <td>{{$vehicle->capacity}}</td>
                  <td>{{$vehicle->vehicle_status}}</td>
                  <td>
                    <a href="/admin/vehicle/{{$vehicle->id}}/details" title="Vehicle Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    <a href="/admin/vehicle/{{$vehicle->id}}/edit" class="label label-warning" title="Edit Vehicle"><i class="fa fa-edit"></i></a>
                    {{-- <a href="/vehicle/{{$vehicle->id}}/delete" class="label label-danger" title="Delete Vehicle" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fa fa-trash"></i></a> --}}
                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <div class="pagination-sm no-margin pull-right">
                {{$vehicles->links()}}
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection