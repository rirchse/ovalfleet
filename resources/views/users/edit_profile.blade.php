@extends('user')
@section('title', 'Update Profile')
@section('content')
<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My Profile</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Profile</li>
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
              <h3 class="box-title">Update My Profile</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                    {{ Form::text('first_name', $profile->first_name, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('middle_name', 'Middle I', ['class' => 'control-label']) }}
                    {{ Form::text('middle_name', $profile->middle_name, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                    {{ Form::text('last_name', $profile->last_name, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => ''])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                    {{ Form::text('contact', $profile->contact, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                    {{ Form::text('address', $profile->address, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('city', 'City:', ['class' => 'control-label']) }}
                    {{ Form::text('city', $profile->city, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('state', 'State:', ['class' => 'control-label']) }}
                    {{ Form::text('state', $profile->state, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('zip_code', 'ZIP Code:', ['class' => 'control-label']) }}
                    {{ Form::text('zip_code', $profile->zip_code, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('country', 'Country:', ['class' => 'control-label']) }}
                    {{ Form::text('country', $profile->country?$profile->country:'USA', ['class' => 'form-control'])}}
                  </div>
                </div>

                @if($user->user_role == 'Fleet Owner')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('vat_id', 'VAT ID:', ['class' => 'control-label']) }}
                    {{ Form::text('vat_id', $profile->vat_id, ['class' => 'form-control'])}}
                  </div>
                </div>
                @endif
                
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="vat_image">VAT Scan Copy</label>
                    <input type="file" id="vat_image" name="vat_image">
                  </div>
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