@extends('user')
@section('title', 'Add New Driver Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Account
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create New User</li>
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
              <h3 class="box-title">Create New User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'create.driver.account', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                  {{ Form::text('first_name', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) }}
                  {{ Form::text('middle_name', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                  {{ Form::text('last_name', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                  {{ Form::email('email', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                  {{ Form::text('contact', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('password', 'Password:', ['class' => 'control-label']) }}
                  {{ Form::text('password', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('confirm_password', 'Confirm Password:', ['class' => 'control-label']) }}
                  {{ Form::text('confirm_password', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('account_type', 'Account Type:', ['class' => 'control-label']) }}
                  <select name="account_type" id="type" class="form-control" required>
                     <option value="">Select One</option>
                     <option value="Driver">I am a Driver</option>
                     <option value="Dispatcher">I am a Dispatcher</option>
                     <option value="Shipper">I am a Shipper</option>
                   </select>
                </div>
                <div class="form-group">
                  {{ Form::label('Company/Driver Licence', 'Company/Organization:', ['class' => 'control-label']) }}
                   {{ Form::text('driver_license', null, ['class' => 'form-control', 'placeholder' => 'Enter Driver\'s Licence Number without hyphen', 'id' => 'driver_license', 'style' => 'display:none'])}}

                   {{ Form::text('organization', null, ['class' => 'form-control', 'placeholder'=>'Company/Organization', 'id' => 'organization' ])}}
                 </div>
                {{-- <div class="form-group">
                  {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                  {{ Form::text('address', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('state', 'State:', ['class' => 'control-label']) }}
                  {{ Form::text('state', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('zip_code', 'ZIP Code:', ['class' => 'control-label']) }}
                  {{ Form::text('zip_code', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('country', 'Country:', ['class' => 'control-label']) }}
                  {{ Form::text('country', null, ['class' => 'form-control'])}}
                </div> --}}                

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
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Create</button>
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