@extends('user')
@section('title', 'Send Invitation')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invitation</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send Invitation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Send Invitation</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'create.invitation', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('email', 'Recipient Email Address:', ['class' => 'control-label']) }}
                  {{ Form::email('email', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  <p>Hi, <br> We are using OvalFleet.com to better manage our business process. Click here to join OvalFleet and connect with us.</p>
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'Additional Message:', ['class' => 'control-label']) }}
                  {{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => 3])}}
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Send</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection