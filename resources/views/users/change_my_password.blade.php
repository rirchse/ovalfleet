@extends('user')
@section('title', 'Change My Password')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Change My Password</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Change My Password</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Change My Password</h4>
          </div>
    {!! Form::model($profile, ['route' => ['user.password_change', $profile->id], 'method' => 'PUT', 'files' => true]) !!}
            <div class="col-md-12">
                
                <div class="form-group label-floating">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('current_password', 'Current Password', ['class' => 'control-label']) }}
                    {{ Form::password('current_password', ['class' => 'form-control']) }}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('password', 'New Password', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('confirm_password', 'Confirm New Password', ['class' => 'control-label']) }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">Update Password</button><br><br>
            </div>

        
        <div class="clearfix"></div>
    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>
@endsection