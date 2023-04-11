@extends('user')
@section('title', 'Update Driver Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Account
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Driver Account</li>
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
              <h3 class="box-title">Update Driver Account</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($driver, ['route' => ['update.driver.account', $driver->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                  {{ Form::text('first_name', $driver->first_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) }}
                  {{ Form::text('middle_name', $driver->middle_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                  {{ Form::text('last_name', $driver->last_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                  {{ Form::email('email', $driver->email, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                  {{ Form::text('contact', $driver->contact, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                  {{ Form::text('address', $driver->address, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('state', 'State:', ['class' => 'control-label']) }}
                  {{ Form::text('state', $driver->state, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('zip_code', 'ZIP Code:', ['class' => 'control-label']) }}
                  {{ Form::text('zip_code', $driver->zip_code, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('country', 'Country:', ['class' => 'control-label']) }}
                  {{ Form::text('country', $driver->country, ['class' => 'form-control'])}}
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