@extends('user')
@section('title', 'Payment Status')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Payment Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Payment</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-9"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Payment Information</h4>
          </div>

          <div class="col-md-12">
            <h1>{{$paymentstatus}}</h1>
            <br><br>
          </div>
                
          <div class="clearfix"></div>
          </div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
