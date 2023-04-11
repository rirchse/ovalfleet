@extends('user')
@section('title', 'View Invoices')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Invoices</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
        <li class="active"> View Invoices</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Invoices</h3>

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
                  <th>Plan Name</th>
                  <th>Payment Date</th>
                  <th>Amount Paid</th>
                  <th>Valid Until</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($invoices as $invoice)
                <?php $r++; ?>

                <tr>
                  <td>{{$invoice->package_name}}</td>
                  <td>{{$invoice->created_at?date('d M Y', strtotime($invoice->created_at)):''}}</td>
                  <td>{{$invoice->paid_amount?'$'.number_format($invoice->paid_amount, 2):''}}</td>
                  <td>{{$invoice->valid_until?date('d M Y', strtotime($invoice->valid_until)):''}}</td>
                  <td>
                    @if($invoice->status == 1)
                    <label class="label label-success">Active</label>
                    @else
                    <label class="label label-warning">Inactive</label>
                    @endif
                  </td>
                  <td>
                    <a href="/invoice/{{$invoice->id}}/details" title="invoice Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/invoice/{{$invoice->id}}/edit" class="label label-warning" title="Edit invoice"><i class="fa fa-edit"></i></a>
                    <a href="/invoice/{{$invoice->id}}/delete" class="label label-danger" title="Delete invoice" onclick="return confirm('Are you sure you want to delete this invoice?');"><i class="fa fa-trash"></i></a> --}}

                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection