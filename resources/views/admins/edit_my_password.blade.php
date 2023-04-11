@extends('admin')
@section('title', 'Change My Password')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Change My Password</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-setting"></i> Settings</a></li>
        <li class="active">Change My Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row"> <!-- left column -->
        <div class="col-md-6"> <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Change My Password</h3>
            </div>
            <!-- /.box-header -->

            {!! Form::model($profile, ['route' => ['admin.password_change.admin', $profile->id], 'method' => 'PUT', 'files' => true]) !!}

            <div class="box-body">
                <div class="col-md-12">
                    
                    <div class="form-group label-floating">
                        {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                        {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                    </div>
                    <div class="form-group label-floating">
                        {{ Form::label('current_password', 'Current Password', ['class' => 'control-label']) }}
                        {{ Form::password('current_password', ['class' => 'form-control', 'required' => '']) }}
                    </div>
                    <div class="form-group label-floating">
                        {{ Form::label('password', 'New Password', ['class' => 'control-label']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'required' => '']) }}
                    </div>
                    <div class="form-group label-floating">
                        {{ Form::label('confirm_password', 'Confirm New Password', ['class' => 'control-label']) }}
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => '']) }}
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"> </i> Save</button>
                </div> <!-- /.box-footer -->
                <div class="clearfix"></div>
                {!! Form::close() !!}

            </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection