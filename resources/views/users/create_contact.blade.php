@extends('user')
@section('title', 'Send Contact')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Contact Form</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send Contact</li>
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
              <h3 class="box-title">Contact for Support or Suggestion</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'create.contact', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('contact_for', 'What is the nature of your inquiry?', ['class' => 'control-label']) }}
                  {{ Form::select('contact_for', [''=>'Select the reason for your inquiry', 'Help with your account' => 'Help with your account', 'Send a suggestion' => 'Send a suggestion', 'Other questions or requests' => 'Other questions or requests'], null, ['class' => 'form-control', 'required' => ''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('message', 'Your Message:', ['class' => 'control-label']) }}
                  {{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => 7, 'placeholder' => 'Please input your suggestion or concern in this box for OvalFleet Support Team.', 'required'=>''])}}
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