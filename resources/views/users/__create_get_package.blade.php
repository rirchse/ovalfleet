@extends('user')
@section('title', 'Service Details')
@section('content')
<?php $user = Auth::user(); ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Service Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
      <li class="active">Details</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Service Plan Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              {{-- <a href="/my_referrals" title="View My Referrals" class="label label-success"><i class="fa fa-list"></i></a> --}}
              {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th>Service Plan:</th>
                  <td>{{$package->package_name}}</td>
                </tr>
                <tr>
                  <th>Plan Charges:</th>
                  <th>${{$package->package_price}}</th>
                </tr>
                <tr>
                  <th>Duration (days)</th>
                  <td>{{$package->duration}}</td>
                </tr>
                <tr>
                  <th>Max Dispatcher</th>
                  <td>{{$package->max_dispatcher}}</td>
                </tr>
                <tr>
                  <th>Max Driver</th>
                  <td>{{$package->max_driver}}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$package['details']}}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="box-footer"></div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Payment Information</h4>
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th>Duration (days)</th>
                  <td>{{$getpackage['actduration']}}</td>
                </tr>
                <tr>
                  <th>Amount Payable</th>
                  <th>${{number_format($getpackage['payable'],2)}}</th>
                </tr>
                <tr>
                  <th>Started From</th>
                  <td>{{date('d M Y')}}</td>
                </tr>
                <tr>
                  <th>Expires On</th>
                  <td>{{date('d M Y', strtotime($getpackage['expdate']))}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="box-footer">
          <div class="col-md-12">
            {!! Form::open(['route' => 'create.payment', 'method' => 'POST', 'files' => true]) !!}
                  <input type="hidden" name="cmd" value="_xclick" />
                  <input type="hidden" name="no_note" value="1" />
                  <input type="hidden" name="lc" value="US" />
                  <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                  <input type="hidden" name="first_name" value="{{$user->first_name}}" />
                  <input type="hidden" name="last_name" value="{{$user->last_name}}" />
                  <input type="hidden" name="payer_email" value="{{$user->email}}" />
                  <input type="hidden" name="package_id" value="{{$package->id}}" />
                  <input type="hidden" name="service" value="{{$package->package_name}}" />
                  <input type="hidden" name="total" value="{{number_format($getpackage['payable'],2)}}" />
                  <input type="hidden" name="actual_duration" value="{{$getpackage['actduration']}}" />
                  <hr>
                  <input type="submit" name="submit" class="btn btn-info pull-right" value="Proceed to Payment"/>
                  <a href="/select_package" class="btn btn-warning pull-right" style="margin-right:15px;">Back</a>
                  <br><br>
              {!!Form::close()!!}
          </div>
        </div>
          <div class="clearfix"></div>
      </div>
    </div><!--row-->
  </section><!-- /.content -->
   
@endsection
