@extends('user')
@section('title', 'Home')
@section('content')

<?php
$user = Auth::user();

//filter shipments
$active_shipment = $completed_shipment = $earning = $receivable = 0;
foreach($shipments as $shipment){
  if($shipment->status == 1){
    $active_shipment ++;
  } else if($shipment->status == 2) {
    $completed_shipment ++;
  }
}

//filter user type for Fleet Owners
$dispatchers = 0;
$shippers = 0;
$drivers = 0;
$fleetowners = 0;
foreach($users as $usar) {
  if($usar->user_role == 'Dispatcher'){
    $dispatchers ++;
  }else if($usar->user_role == 'Driver'){
    $drivers ++;
  }else if($usar->user_role == 'Shipper'){
    $shippers ++;
  }else if($usar->user_role == 'Fleet Owner'){
    $fleetowners ++;
  }
}

//get all vehicles for Fleet Owners
$active_vehicles = 0;
$inactive_vehicles = 0;
foreach($vehicles as $vehicle){
  if($vehicle->vehicle_status == 'Active'){
    $active_vehicles ++;
  }else{
    $inactive_vehicles ++;
  }
}

// get referrals for all users
$act_referrals = 0;
$inact_referrals = 0;

foreach($referrals = DB::table('users')->where('referral', $user->id)->get() as $referral) {

  if($referral->status == 1){
    $act_referrals ++;
  } else if($referral->status == 0) {
    $inact_referrals ++;
  }
}

$pending_referrals = DB::table('referrals')->where('refer_by', $user->id)->where('status', 0)->select('id')->get();

?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$user->user_role}} Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @if($user->user_role == 'Fleet Owner')
      @include('users.dashboard_fleetowner')
      @elseif($user->user_role == 'Driver')
      @include('users.dashboard_driver')
      @elseif($user->user_role == 'Dispatcher')
      @include('users.dashboard_dispatcher')
      @elseif($user->user_role == 'Shipper')
      @include('users.dashboard_shipper')
      @endif

    </section><!-- /.content -->
    

@endsection