@extends('user')
@section('title', 'Send Contact')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Submit a Ticket</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Support</a></li>
        <li class="active">Submit a Ticket</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-lg-8 col-md-8" style="max-width:700px">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Submit a Ticket for Support or Suggestion</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'ticket.store', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('reason', 'What is the nature of your inquiry?', ['class' => 'control-label']) }}
                  {{ Form::select('reason', [
                  ''=>'', 
                  'Help with your account' => 'Help with your account', 
                  'Billing question' => 'Billing question', 
                  'Service plan inquiry' => 'Service plan inquiry',
                  'Technical support' => 'Technical support', 
                  'Referral inquiry' => 'Referral inquiry', 
                  'Send a suggestion' => 'Send a suggestion',
                  'Other questions or requests' => 'Other questions or requests'
                  ], old('reason'), ['class' => 'form-control', 'required' => ''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'Your Message:', ['class' => 'control-label']) }}
                  {{ Form::textarea('message', null, ['class' => 'textarea form-control', 'rows' => 7, 'placeholder' => 'Please input your suggestion or concern in this box for OvalFleet Support Team.', 'required'=>''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'Attach File:', ['class' => 'control-label']) }}
                  {{ Form::file('image') }}
                </div>

              </div> <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Submit</button>
              </div>
            {!! Form::close() !!}
          </div> <!-- /.box -->

        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection