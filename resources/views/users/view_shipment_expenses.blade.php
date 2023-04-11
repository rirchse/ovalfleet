@extends('user')
@section('title', 'View Shipments')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Shipment Expenses</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipments</a></li>
        <li class="active">Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-10">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Shipment Expense</h3>

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
                <tr><td colspan="8" style="font-size: 16px;"><b>Shipment Details:</b><br> Origin: {{$shipment->loading_point}}. &nbsp; &nbsp;  Destination: {{$shipment->unload_point}}. <br>Fleet Owner:<?php $flowner = App\User::find($shipment->fleetowner_id); ?> {{$flowner?$flowner->first_name.' '.$flowner->last_name:''}}. &nbsp; &nbsp; Shipper: <?php $shipper = App\User::find($shipment->shipper_id); ?> {{$shipper?$shipper->first_name.' '.$shipper->last_name:''}} <span style="float:right"><a href="/shipment/{{$shipment->id}}/details" class="label label-info" title="Shipment Details"><i class="fa fa-file-text"></i></a>
                <a href="/view_shipments" title="All Shipments" class="label label-success"><i class="fa fa-list"></i></a> &nbsp; 
              </span>
                </td></tr>
                <tr>
                  <th>ID</th>
                  <th>Created On</th>
                  <th>Expense Type</th>
                  <th>Expense Date</th>
                  <th>Time</th>
                  <th>Amount</th>
                  <th>Notes</th>
                  <th>Action</th>
                </tr>

                @foreach($expenses as $expense)

                <tr>
                  <td>{{$expense->id}}</td>
                  <td>{{ date('d M Y', strtotime($expense->created_at))}}</td>
                  <td>{{$expense->cause}}</td>
                  <td>{{$expense->date?date('d M Y', strtotime($expense->date)):''}}</td>
                  <td>{{date('h:i A', strtotime($expense->start_time)).' - '.date('h:i A', strtotime($expense->end_time))}}</td>
                  <td>{{$expense->expense?'$'.number_format($expense->expense, 2):''}}</td>
                  <td>{{$expense->notes}}</td>
                  <td>
                    <a href="/shipment/{{$shipment->id}}/expense/{{ $expense->id }}/details" class="label label-info" title="Expense details"><i class="fa fa-file-text"></i></a>
                    <a href="/shipment/{{$shipment->id}}/expense/{{$expense->id}}/edit" class="label label-warning" title="Edit expense"><i class="fa fa-edit"></i></a>
                    {{-- <a href="/shipment/{{$expense->shipment_id}}/expense/{{$expense->id}}/delete" class="label label-danger" title="Delete expense" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-trash"></i></a> --}}
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$expenses->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection