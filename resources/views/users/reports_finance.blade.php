@extends('user')
@section('title', 'Financial Reports')
@section('content')

<?php
  $user = Auth::user();

  $initiated = $pickup = $intransit = $delivered = $completed = $cancelled = $receiveable = $revenue = $discom = $drivcom = $expenses = 0;
  foreach ($shipments as $shipment) {
    if($shipment->status == 2){
      $intransit ++;
      $receiveable += $shipment->shipment_cost+$shipment->extra_charge;
    }elseif($shipment->status == 3){
      $delivered ++;
      $receiveable += $shipment->shipment_cost+$shipment->extra_charge;
    }elseif($shipment->status == 4){
      $completed ++;
      $revenue += $shipment->shipment_cost+$shipment->extra_charge;
      $discom   += $shipment->dispatcher_commission;
      $drivcom  += $shipment->driver_commission;
    }elseif($shipment->status == 5){
      $cancelled ++;
    }

    $expenses += DB::table('shipment_expenses')->where('shipment_id', $shipment->id)->sum('expense');
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
    
    <style type="text/css">
    .reports .box-body{font-size: 25px;font-weight: bold;text-align: center;}
    /*.reports{max-width: 200px;}*/
    .reports .box-title{font-size: 16px}
    </style>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Accounts Receivable</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($receiveable, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-info box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Revenue</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($revenue, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" title="(Accounts Receivable + Revenue)">Total</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($receiveable+$revenue, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Shipment Expenses</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($expenses, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->
        
        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Dispatcher Commission</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($discom, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 reports">
          <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Driver Commission</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> <!-- /.box-tools -->
            </div> <!-- /.box-header -->
            <div class="box-body">${{number_format($drivcom, 2)}}</div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->


      <div class="row">
        <div class="col-md-6">
          <div class="box">
            {!! Form::open(['route' => 'reports.finance', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
              <h4 class="box-title">Search Reports</h4>
                <div class="col-md-5">
                  <div class="form-group">
                    {{ Form::label('start_date', 'Start Date:', ['class' => 'control-label']) }}
                    {{ Form::text('start_date', date('m/d/Y', strtotime('-1 days')), ['class' => 'form-control datepicker', 'required'=>'required'])}}
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

        @if(count($shipments) > 0)
        <div class="col-xs-12">
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
                  <th>Created On</th>
                  <th title="Shipment Cost">Cost</th>
                  <th>Extra Charge</th>
                  <th>Total Cost</th>
                  <th>[Dispatcher &nbsp; &</th>
                  <th>Commission]</th>
                  <th>[Driver &nbsp; &</th>
                  <th>Commission]</th>
                  <th title="Shipment Expenses">Expenses</th>
                  <th>Net Revenue</th>
                  <th>Shipment Status</th>
                </tr>

                <?php $total_costs = 0; ?>

                @foreach($shipments as $shipment)
                <?php $total_costs += $shipment->shipment_cost; ?>

                <tr>
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
                  <td>{{$shipment->shipment_cost?'$'.number_format($shipment->shipment_cost, 2):''}}</td>
                  <td>{{$shipment->extra_charge > 0?'$'.number_format($shipment->extra_charge, 2):''}}</td>
                  <td>${{$shipment->shipment_cost?number_format($shipment->shipment_cost+$shipment->extra_charge, 2):''}}</td>
                  <td>{!!App\User::find($shipment->dispatcher_id)?'&nbsp; '.App\User::find($shipment->dispatcher_id)->first_name:''!!}</td>
                  <td>{{$shipment->dispatcher_commission > 0?'$'.number_format($shipment->dispatcher_commission, 2):''}}</td>
                  <td>{!!App\User::find($shipment->driver_id)?'&nbsp; '.App\User::find($shipment->driver_id)->first_name:''!!}</td>
                  <td>{{$shipment->driver_commission > 0?'$'.number_format($shipment->driver_commission, 2):''}}</td>
                  <td>
                    <?php $expenses = DB::table('shipment_expenses')->where('shipment_id', $shipment->id)->sum('expense'); ?>
                    <a target="_blank" title="View Shipment Expenses" href="/view_shipment/{{$shipment->id}}/expenses">{{$expenses?'$'.number_format($expenses, 2):''}}</a>
                  </td>
                  <td>${{number_format(($shipment->shipment_cost+$shipment->extra_charge)-($shipment->dispatcher_commission+$shipment->driver_commission+$expenses), 2)}}</td>
                  <td>
                    <a target="_blank" href="/shipment/{{$shipment->id}}/details">
                    @if($shipment->status == 0)
                    <span class="text-default">Initiated</span>
                    @elseif($shipment->status == 1)
                    <span class="text-primary">Pick up Confirmed</span>
                    @elseif($shipment->status == 2)
                    <span class="text-warning">In Transit</span>
                    @elseif($shipment->status == 3)                    
                    <span class="text-info">Delivered</span>
                    @elseif($shipment->status == 4)
                    <span class="text-success">Completed</span>
                    @elseif($shipment->status == 5)
                    <span class="text-danger">Cancelled</span>
                    @endif
                    </a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$shipments->links()}} --}}
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