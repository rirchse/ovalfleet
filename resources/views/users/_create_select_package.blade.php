@extends('user')
@section('title', 'Select Service Plan')
@section('content')
<?php 
  $user = Auth::user();
  $mypackage = DB::table('mypackages')->where('user_id', $user->id)->orderBy('id', 'DESC')->first();
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Select Service Plan</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Select Service Plan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Select a Service Plan</h3>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="box-body">
              @foreach($packages as $package)
              <div class="col-md-3 col-sm-6" style="min-height:260px;">
                <!-- small box -->
                <div class="small-box bg-{{$package->bg_color}}">
                  <div class="inner">
                    <h3 title="Total Active Users">${{number_format($package->package_price, 0)}}</h3>
                    <h4>{{$package->package_name}}</h4>
                    <p>1 - {{$package->max_dispatcher}} dispatchers<br>Max {{$package->max_driver}} drivers</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats"></i>
                  </div>
                  <a href="/get_package/{{$package->id}}" class="btn btn-{{$package->btn_color}} btn-block btn-lg"> {{!empty($mypackage) && $mypackage->package_id == $package->id?'Renew':'Get Started'}} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                @if(!empty($mypackage) && $mypackage->package_id == $package->id)
                <div class="text-danger text-center">Current Service Plan</div>
                @endif
              </div>
              <!-- ./col -->
              @endforeach

{{--               <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3 title="Total Active Users">$155</h3>
                    <h4>Preferred</h4>
                    <p>1 - 10 dispatchers<br>Max 10 drivers</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats"></i>
                  </div>
                  <a href="/get_package/preferred" class="btn btn-info btn-block btn-lg">Get Started <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3 title="Total Shipment">$575</h3>
                    <h4>Enterprise</h4>
                    <p>1 - 50 dispatchers<br>Max 50 drivers</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-doller"></i>
                  </div>
                  <a href="/get_package/enterprise" class="btn btn-primary btn-block btn-lg">Get Started <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3 title="Total Vehicles">$985</h3>
                    <h4>Premium</h4>
                    <p>1 – 100 dispatchers<br>Max 100 drivers</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-add"></i>
                  </div>
                  <a href="/get_package/premium" class="btn btn-danger btn-block btn-lg">Get Started <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col --> --}}
            </div> <!-- /.row -->
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection