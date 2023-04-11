@extends('admin')
@section('title', 'Vehicle Archive List')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vehicles Archive</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vehicles</a></li>
        <li class="active"> View Vehicle Archive</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Deleted Vehicles</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>License Plate</th>
                  <th>VIN/SN</th>
                  <th>Vehicle Name/Type</th>
                  <th>Color</th>
                  <th>Capacity</th>
                  <th>Purchase Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($vehicles as $vehicle)
                <?php $r++; ?>

                <tr>
                  <td>{{$vehicle->license_plate}}</td>
                  <td>{{$vehicle->vinsn}}</td>
                  <td>{{$vehicle->name_type}}</td>
                  <td>{{$vehicle->color}}</td>
                  <td>{{$vehicle->capacity}}</td>
                  <td>{{$vehicle->purchase_date? date('d M Y', strtotime($vehicle->purchase_date)):''}}</td>
                  <td>{{$vehicle->vehicle_status}}</td>
                  <td>
                    {{-- <a href="/vehicle/{{$vehicle->id}}/details" title="Vehicle Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    <a href="/vehicle/{{$vehicle->id}}/edit" class="label label-warning" title="Edit Vehicle"><i class="fa fa-edit"></i></a> --}}
                    <a href="/admin/vehicle_archive/{{$vehicle->id}}/return" class="label label-warning" title="Restore from archive" onclick="return confirm('Are you sure you want to restore this vehicle?');"><i class="fa fa-repeat"></i></a>
                    {{-- <a href="#">Add Expenses</a> --}}
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