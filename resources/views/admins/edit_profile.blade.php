@extends('admin')
@section('title', 'Profile Update')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        My Profile
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
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
              <h3 class="box-title">Edit My Profile</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($profile, ['route' => ['admin.profile.update', $profile->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                  {{ Form::text('first_name', $profile->first_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) }}
                  {{ Form::text('middle_name', $profile->middle_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                  {{ Form::text('last_name', $profile->last_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                  {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => ''])}}
                </div>
                <div class="form-group">
                  {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                  {{ Form::text('contact', $profile->contact, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('job_title', 'Job Title:', ['class' => 'control-label']) }}
                  {{ Form::text('job_title', $profile->job_title, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('dob', 'Date of Birth:', ['class' => 'control-label']) }}
                  {{ Form::text('dob', $profile->dob, ['class' => 'form-control', 'placeholder' => 'mm/dd/yyyy'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('admin_role', 'Admin Role:', ['class' => 'control-label']) }}
                  {{ Form::text('admin_role', $profile->user_role, ['class' => 'form-control', 'disabled'=>''])}}
                </div>
                <div class="form-group">
                  <label for="image">Profile Image</label>
                  <input type="file" id="image" name="image">
                  {{-- <p class="help-block">Example block-level help text here.</p> --}}
                </div>
                {{-- <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div> --}}

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
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