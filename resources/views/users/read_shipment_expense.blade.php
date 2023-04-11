@extends('user')
@section('title', 'Shipment Expense Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Shipment Expense Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipment Expense > View expenses</a></li>
        <li class="active">Shipment Expense Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Shipment Expense Details</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              <a href="/view_shipment/{{$expense->shipment_id}}/expenses" title="View shipment expenses" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="/shipment/{{$expense->shipment_id}}/expense/{{$expense->id}}/edit" class="label label-warning" title="Edit shipment expense"><i class="fa fa-edit"></i></a>
              <a href="/shipment/{{$expense->shipment_id}}/expense/{{$expense->id}}/delete" class="label label-danger" title="Delete shipment expense" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-trash"></i></a>
          </div>
            <table class="table">
              <tbody>
                <tr>
                  <th>Expense Type:</th>
                  <td>{{$expense->cause}}</td>
                </tr>                
                <tr>
                  <th>Expense Date:</th>
                  <td>{{date('d M Y', strtotime($expense->date))}}</td>
                </tr>
                <tr>
                  <th>Start Time:</th>
                  <td>{{date('h:i A', strtotime($expense->start_time))}}</td>
                </tr>
                <tr>
                  <th>End Time:</th>
                  <td>{{date('h:i A', strtotime($expense->end_time))}}</td>
                </tr>
                <tr>
                  <th>Amount:</th>
                  <td>{{$expense->expense?'$'.number_format($expense->expense, 2):''}}</td>
                </tr>
                <tr>
                  <th>Notes:</th>
                  <td>{{$expense->notes}}</td>
                </tr>
              </tbody>
          </table>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection