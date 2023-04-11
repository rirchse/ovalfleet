@extends('user')
@section('title', 'Invoice Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Invoice Information</h4>
          </div>
                <div class="col-md-12 text-right toolbar-icon">
                    <a href="/view_invoices" title="View All Invoices" class="label label-success"><i class="fa fa-list"></i></a>
                    <a target="_blank" href="/invoice/{{$invoice->id}}/pdf" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
                    {{-- <a href="/view_invoices" class="label label-warning" title=" Send over Email"><i class="fa fa-envelope"></i></a> --}}
                </div>
                <div class="col-md-12">
                  <table class="table">
                      <tbody>
                        <tr>
                          <th>Name:</th>
                          <td>{{$invoice->first_name.' '.$invoice->middle_name.' '.$invoice->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Company:</th>
                          <td>{{$invoice->organization}}</td>
                        </tr>
                        <tr>
                          <th>Address:</th>
                          <td>{{$invoice->address.' '.$invoice->city.' '.$invoice->state.' '.$invoice->zip_code.' '.$invoice->country}}</td>
                        </tr>
                        <tr>
                          <th>Email:</th>
                          <td>{{$invoice->email}}</td>
                        </tr>
                        <tr>
                          <th>VAT ID:</th>
                          <td>{{$invoice->vat_id}}</td>
                        </tr>
                        <tr>
                          <th>Phone:</th>
                          <td>{{$invoice->contact}}</td>
                        </tr>
                        <tr>
                          <th>Plan Name:</th>
                          <td>{{$invoice->package_name}}</td>
                        </tr>
                        <tr>
                          <th>Amount Paid:</th>
                          <td>{{$invoice->paid_amount?'$'.number_format($invoice->paid_amount, 2):''}}</td>
                        </tr>
                        <tr>
                          <th>Valid Until:</th>
                          <td>{{date('d M Y', strtotime($invoice->valid_until))}}</td>
                        </tr>
                        <tr>
                          <th>Status:</th>
                          <td>
                            @if($invoice->status == 0)
                            <span class="label label-warning">Unpaid</span>
                            @elseif($invoice->status == 1)
                            <span class="label label-success">Paid</span>
                            @elseif($invoice->status == 2)
                            <span class="label label-danger">Unpaid</span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Invoice Delivery:</th>
                          <td>Email Only</td>
                        </tr>
                        <tr>
                          <th>Record Created On:</th>
                          <td>{{date('d M Y h:i:s A',strtotime($invoice->created_at) )}} </td>
                        </tr>
                      </tbody>
                  </table>
                </div>
                
                <div class="clearfix"></div>
                </div>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
