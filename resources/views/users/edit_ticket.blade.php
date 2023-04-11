@extends('user')
@section('title', 'Edit Ticket')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Edit Ticket</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Support</a></li>
        <li class="active">Edit Ticket</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit and Submit the Ticket for Support or Suggestion</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/ticket/{{$ticket->id}}" title="Ticket Details" class="label label-info"><i class="fa fa-file-text"></i></a>
              <a href="/ticket" title="View Tickets" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($ticket, ['route' => ['ticket.update', $ticket->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('reason', 'What is the nature of your inquiry?', ['class' => 'control-label']) }}
                  {{ Form::select('reason', [
                  ''=>'', 
                  'Help with your account' => 'Help with your account', 
                  'Billing question'=>'Billing question', 
                  'Service plan inquiry'=>'Service plan inquiry',
                  'Technical support'=>'Technical support', 
                  'Referral inquiry'=>'Referral inquiry', 
                  'Send a suggestion'=>'Send a suggestion',
                  'Other questions or requests'=>'Other questions or requests'
                  ], $ticket->reason, ['class' => 'form-control', 'required' => ''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'Your Message:', ['class' => 'control-label']) }}
                  {{ Form::textarea('message', $ticket->details, ['class' => 'textarea form-control', 'rows' => 7, 'placeholder' => 'Please input your suggestion or concern in this box for OvalFleet Support Team.', 'required'=>''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'File:', ['class' => 'control-label']) }}
                  {{ Form::file('image') }}
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Save & Submit</button>
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