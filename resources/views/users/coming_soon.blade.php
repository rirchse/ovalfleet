@extends('user')
@section('title', 'View Tickes')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <h1>View Tickes</h1> --}}
      <ol class="breadcrumb">
        {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Supports</a></li> --}}
        {{-- <li class="active">View Tickets</li> --}}
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            {{-- <h4 class="box-title">List of Ticket</h4> --}}
          </div>
                <div class="col-md-12 text-right toolbar-icon">
                    {{-- <a href="/view_invoices" title="View All Invoices" class="label label-success"><i class="fa fa-list"></i></a> --}}
                    {{-- <a href="/invoice/{{$invoice->id}}/pdf" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
                    {{-- <a href="/view_invoices" class="label label-warning" title=" Send over Email"><i class="fa fa-envelope"></i></a> --}}
                </div>
                <div class="col-md-12">
                  <h1>Coming Soon...</h1>
                </div>
                
                <div class="clearfix"></div>
                </div>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
