@extends('user')
@section('title', 'Vehicle Details')
@section('content')
<?php $user = Auth::user(); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vehicle Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vehicles > View Vehicles</a></li>
        <li class="active">Vehicle Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-9"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Vehicle Details</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              <a href="/view_vehicles" title="View Vehicles" class="label label-success"><i class="fa fa-list"></i></a>
              @if($user->user_role == 'Fleet Owner')
              <a href="/vehicle/{{$vehicle->id}}/edit" class="label label-warning" title="Edit Vehicle"><i class="fa fa-edit"></i></a>
              <a href="/vehicle/{{$vehicle->id}}/delete" class="label label-danger" title="Delete Vehicle" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fa fa-trash"></i></a>
              @endif
              <a target="_blank" href="/vehicle/{{$vehicle->id}}/pdf" title="Print Vehicle" class="label label-info"><i class="fa fa-print"></i></a>
          </div>
          <div class="col-md-6"><table class="table">
              <tbody>
                <tr>
                  <th>Vehicle Name:</th>
                  <td>{{$vehicle->name_type}}</td>
                </tr>
                <tr>
                  <th>VIN/SN:</th>
                  <td>{{$vehicle->vinsn}}</td>
                </tr>
                <tr>
                  <th>License Plate:</th>
                  <td>{{$vehicle->license_plate}}</td>
                </tr>
                <tr>
                  <th>Year:</th>
                  <td>{{$vehicle->year}}</td>
                </tr>
                <tr>
                  <th>Make:</th>
                  <td>{{$vehicle->make}}</td>
                </tr>
                <tr>
                  <th>Model No:</th>
                  <td>{{$vehicle->model_no}}</td>
                </tr>
                <tr>
                  <th>Registration State/Province:</th>
                  <td>{{$vehicle->reg_state}}</td>
                </tr>
                <tr>
                  <th>Vehicle Color:</th>
                  <td>{{$vehicle->color}}</td>
                </tr>
                <tr>
                  <th>Body Type:</th>
                  <td>{{$vehicle->body_type}}</td>
                </tr>
              </tbody>
          </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th>Purchase Date:</th>
                  <td>{{$vehicle->purchase_date?date('d M Y', strtotime($vehicle->purchase_date)):''}}</td>
                </tr>
                <tr>
                  <th>Mileage (when purchased):</th>
                  <td>{{$vehicle->mileage}}</td>
                </tr>
                 <tr>
                  <th>Status:</th>
                  <td>{{$vehicle->vehicle_status}}</td>
                </tr>
                <tr>
                  <th>Record Created On:</th>
                  <td>{{date('d M Y h:i:s',strtotime($vehicle->created_at) )}} </td>
                </tr>
                <tr>
                  <th>Vehicle Image:</th>
                  <td>                    
                    <img src="/img/vehicles/{{$vehicle->photo}}" class="img-responsive" alt="Photo not found!" style="max-width:160px;border:1px solid #ddd; padding:5px">
                  </td>
                </tr>
                <tr>
                  <th>Vehicle Documentation:</th>
                  <td>
                    @if($vehicle->document)
                    <a class="btn btn-info" href="/img/vehicle_documents/{{$vehicle->document}}">Document</a>
                    @else
                    Document not attached.
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Comment:</th>
                  <td>{{$vehicle->comments}}</td>
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