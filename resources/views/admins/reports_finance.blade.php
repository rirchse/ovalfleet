@extends('admin')
@section('title', 'Financial Reports')
@section('content')

<?php

  $paid_value = $sales_thismonth = $sales_premonth = 0;
  foreach ($payments as $payment) {
    if($payment->status == 1){
      $paid_value += $payment->paid_amount;
    }

    if(date('Y-m', strtotime($payment->created_at)) == date('Y-m')){
      $sales_thismonth +=  $payment->paid_amount;
    }

    if(date('Y-m', strtotime($payment->created_at)) == date('Y-m', strtotime('-1 month'))){
      $sales_premonth +=  $payment->paid_amount;
    }
  }

  //shipment values
  $receivable = $delivered = $revenue = $cancelled = 0;
  foreach (DB::table('shipments')->get() as $shipment) {
    if($shipment->status == 0 || $shipment->status == 1 || $shipment->status == 2 || $shipment->status == 3){
      $receivable += $shipment->shipment_cost+$shipment->extra_charge;
    }
    // elseif($shipment->status == 3){
    //   $delivered += $shipment->shipment_cost+$shipment->extra_charge;
    // }
    elseif($shipment->status == 4){
      $revenue += $shipment->shipment_cost+$shipment->extra_charge;
    }elseif($shipment->status == 5){
      $cancelled ++;
    }
  }
?>

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Financial Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active"> Financial</li>
      </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <h4 class="box-title">Financial Details of Shipments</h4>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Accounts Receivable</span>
              <span class="info-box-number">${{number_format($receivable, 2)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Revenue</span>
              <span class="info-box-number">${{number_format($revenue, 2)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        {{-- <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Delivered</span>
              <span class="info-box-number">${{number_format($receivable, 2)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> <!-- /.col --> --}}
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total</span>
              <span class="info-box-number">${{number_format($receivable+$delivered+$revenue, 2)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <h4 class="box-title">Financial Details of Subscriptions</h4>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales Last Month</span>
              <span class="info-box-number">${{number_format($sales_premonth, 2)}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales This Month</span>
              <span class="info-box-number">${{number_format($sales_thismonth, 2)}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Sales</span>
              <span class="info-box-number">${{number_format($paid_value, 2)}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->


      <div class="row">
        <div class="col-md-6">
          <div class="box">
            {!! Form::open(['route' => 'admin.reports.finance', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
              <h4 class="box-title">Search Reports</h4>
                <div class="col-md-5">
                  <div class="form-group">
                    {{ Form::label('start_date', 'Start Date:', ['class' => 'control-label']) }}
                    {{ Form::text('start_date', date('m/d/Y', strtotime('-1 day')), ['class' => 'form-control datepicker', 'required'=>'required'])}}
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    {{ Form::label('end_date', 'End Date:', ['class' => 'control-label']) }}
                    {{ Form::text('end_date', date('m/d/Y'), ['class' => 'form-control datepicker', 'required'=>'required'])}}
                  </div>
                </div>
                <div class="col-md-2"><br>
                  <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Submit</button>
                </div>

              </div>
              <!-- /.box-body -->
            {!! Form::close() !!}
          </div>
        </div>

        @if(count($payments) > 0)
        <div class="row"></div>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Financial Activities</h3>

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
                  <th>Amount Paid</th>
                  <th>Valid Until</th>
                  <th>Status</th>
                  <th>Created On</th>
                </tr>

                <?php $total_costs = 0; ?>

                @foreach($payments as $shipment)
                <?php $total_costs += $shipment->paid_amount; ?>

                <tr>
                  <td>${{number_format($shipment->paid_amount, 2)}}</td>
                  <td>{{$shipment->valid_until?date('M d Y', strtotime($shipment->valid_until)):''}}</td>
                  <td>
                    @if($shipment->status == 1)
                    <span class="text-success">Active</span>
                    @else
                    <span class="text-danger">Inactive</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
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
        .
        @endif
      </div>
    </section>
    <!-- /.content -->

@endsection