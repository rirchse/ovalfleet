@extends('user')
@section('title', 'Driver Reports')
@section('content')

<?php
  $user = Auth::user();

  $onroad = $intransit = $completed = $cancelled = 0;
  foreach ($drivers as $driver) {
    if(App\shipment::where('driver_id', $driver->id)->whereIn('status', [1,2])->first()){
      $onroad ++; 
    }
  }

?>

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Driver Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Drivers</li>
      </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">In-Transit</span>
              <span class="info-box-number">{{$onroad}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Available</span>
              <span class="info-box-number">{{count($drivers) - $onroad}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <div class="row">

        @if(count($drivers) > 0)
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Drivers</h3>

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
                  <th>Shipment ID</th>
                  <th>Account No.</th>
                  <th>First Name</th>
                  <th>Middle I</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  {{-- <th>Action</th> --}}
                </tr>

                @foreach($drivers as $user)

                <tr>
                  <td>{{$user->id?App\Shipment::where('driver_id', $user->id)->orderBy('id', 'DESC')->first()->id:''}}</td>
                  <td>{{$user->account_number}}</td>
                  <td>{{$user->first_name}}</td>
                  <td>{{$user->middle_name}}</td>
                  <td>{{$user->last_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->contact}}</td>
                  <td>
                    @if($user->status == 1)
                    <span class="label label-success">Active</span>
                    @else
                    <span class="label label-warning">Unverified</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($user->created_at))}}</td>
                  {{-- <td>
                    <a href="/my/{{strtolower($user->user_role)}}/{{$user->id}}/details" title="My {{$user->user_role}} Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                  </td> --}}
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
          </div>
          <!-- /.box -->
        </div>
        @endif
      </div>
    </section>
    <!-- /.content -->

@endsection