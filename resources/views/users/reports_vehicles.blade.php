@extends('user')
@section('title', 'Vehicle List')
@section('content')

<?php
  $user = Auth::user();

  $active = $inactive = $outservice = $archive = 0;
  foreach ($vehicles as $vehicle) {
    if($vehicle->vehicle_status == 'Active'){
      $active ++; 
    }elseif($vehicle->vehicle_status == 'Inactive'){
      $inactive ++;
    }elseif($vehicle->vehicle_status == 'In Garage'){
      $outservice ++;
    }elseif($vehicle->vehicle_status == 'Archived'){
      $archive ++;
    }
  }
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vehicle Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active"> Vehicle Reports</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Available</span>
              <span class="info-box-number">{{$active}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">On the Road</span>
              <span class="info-box-number">{{count(DB::table('shipments')->where('fleetowner_id', $user->id)->where('status', 2)->whereNotNull('vehicle_id')->get())}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Out of Service</span>
              <span class="info-box-number">{{$outservice}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Archived</span>
              <span class="info-box-number">{{$archive}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Vehicle Reports</h3>

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
                  <th>License Plate</th>
                  <th>VIN/SN</th>
                  <th>Vehicle Name/Type</th>
                  <th>Color</th>
                  <th>Capacity(tons)</th>
                  <th>Purchase Date</th>
                  <th>Truck Location</th>
                  <th>Status</th>
                  {{-- <th>Actions</th> --}}
                </tr>
                <?php $r = 0; ?>
                {{-- {{dd($vehicles)}} --}}

                @foreach($vehicles as $vehicle)
                <?php $r++; ?>

                <tr>
                  <td>{{$vehicle->license_plate}}</td>
                  <td>{{$vehicle->vinsn}}</td>
                  <td>{{$vehicle->name_type}}</td>
                  <td>{{$vehicle->color}}</td>
                  <td>{{$vehicle->capacity}}</td>
                  <td>{{$vehicle->purchase_date? date('d M Y', strtotime($vehicle->purchase_date)):''}}</td>
                  <td>
                    <?php
                    $shipment = App\Shipment::where('vehicle_id', $vehicle->id)->orderBy('id', 'DESC')->whereIn('status', [3, 4])->first(); ?>
                    {{$shipment?$shipment->unload_point:''}}
                  </td>
                  <td>{{$vehicle->vehicle_status}}</td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <div class="pagination-sm no-margin pull-right">
                {{-- {{$vehicles->links()}} --}}
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection