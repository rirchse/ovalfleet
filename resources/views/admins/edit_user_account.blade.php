@extends('admin')
@section('title', 'Edit User Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Account
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User Account</li>
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
              <h3 class="box-title">Edit User Account</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/admin/user/{{$user->id}}/details" class="label label-info" title="User Details"><i class="fa fa-file-text"></i></a>
              <a href="/admin/view_users/{{Session::get('_types')}}" title="View {{Session::get('_types')}} users" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="/admin/user/{{$user->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-trash"></i></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($user, ['route' => ['update.user.account', $user->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="form-group">
                  {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                  {{ Form::text('first_name', $user->first_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) }}
                  {{ Form::text('middle_name', $user->middle_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                  {{ Form::text('last_name', $user->last_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                  {{ Form::email('email', $user->email, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                  {{ Form::text('contact', $user->contact, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                  {{ Form::text('address', $user->address, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('state', 'State:', ['class' => 'control-label']) }}
                  {{ Form::text('state', $user->state, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('zip_code', 'ZIP Code:', ['class' => 'control-label']) }}
                  {{ Form::text('zip_code', $user->zip_code, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('country', 'Country:', ['class' => 'control-label']) }}
                  {{ Form::text('country', $user->country, ['class' => 'form-control'])}}
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