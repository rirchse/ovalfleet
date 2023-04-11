@extends('admin')
@section('title', 'Create New Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create a Account</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Create a Account</li>
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
              <h3 style="color: #800" class="box-title">Create a New Account</h3>
            </div>
            <!-- /.box-header -->

    {!! Form::open(['route' => 'account.store', 'method' => 'POST', 'files' => true]) !!}
    <div class="box-body">
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('user_role', 'User Permission:', ['class' => 'control-label']) }}
                    <select name="user_role" class="form-control" required onchange="nameChange(this)">
                        <option value="">Select Permission</option>
                        {{-- <option value="SUPER-ADMIN">SUPER-ADMIN</option> --}}
                        <option value="ADMIN">ADMIN</option>
                        <option value="SUPPORT">Support Team</option>
                    </select>
                    <input type="hidden" value="" name="user_role_name" id="rolename">
                </div>
            </div>            
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('profile_image', 'Profile Picture:', ['class' => 'control-label']) }}
                    <input type="file" class="form-control" name="profile_image">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'required' => ''])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                    {{ Form::text('last_name', null, ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', null, ['class' => 'form-control', 'required' => '']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('contact', 'Contact No.', ['class' => 'control-label']) }}
                    {{ Form::text('contact', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control', 'required' => '', 'placeholder' => 'Min:8 & Max:32 characters']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('confirm_password', 'Confirm Password', ['class' => 'control-label']) }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => '']) }}
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="form-group label-floating">
                    {{ Form::label('dob', 'Date of Birth', ['class' => 'control-label']) }}
                    {{ Form::text('dob', null, ['class' => 'form-control datepicker']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group label-floating">
                    {{ Form::label('job_title', 'Designation', ['class' => 'control-label']) }}
                    {{ Form::text('job_title', null, ['class' => 'form-control']) }}
                </div>
            </div> --}}
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
        
        <div class="clearfix"></div>
    {!! Form::close() !!}

            </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->

    <script type="text/javascript">
    function nameChange(elm){
        document.getElementById('rolename').value = elm.options[elm.options.selectedIndex].innerHTML;
    }
    </script>
@endsection