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
            {{-- {{App\Package::where('duration', 'day')->where('status', 2)->get()}} --}}
            @if(count(App\Package::where('duration', 'day')->where('status', 1)->get()) > 0)
            
            <!-- daily service plans -->
            <div class="box-header with-border">
              <h3 class="box-title">Daily Service Plans</h3>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="box-body">
              @foreach($packages as $package)
              @if($package->duration == 'day')
              @include('users.service-plans')
              @endif
              @endforeach
            </div><!-- /.box-body -->
            @endif

            @if(count(App\Package::where('duration', 'month')->where('status', 1)->get()) > 0)
            <!-- monthly service plans -->
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Service Plans</h3>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="box-body">
              @foreach($packages as $package)
              @if($package->duration == 'month')
              @include('users.service-plans')
              @endif
              @endforeach
            </div> <!-- /.box-body -->
            @endif

            @if(count(App\Package::where('duration', 'year')->where('status', 1)->get()) > 0)

            <div class="box-header with-border">
                <h3 class="box-title">Yearly Service Plans</h3>
              </div>
              <div class="box-body">
              @foreach($packages as $package)
              @if($package->duration == 'year')
              @include('users.service-plans')
              @endif
              @endforeach
            </div> <!-- /.box-body -->
            @endif

          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection