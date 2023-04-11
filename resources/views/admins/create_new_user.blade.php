@extends('admin')
@section('title', 'User Profile')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="rose">
                    <i class="material-icons">edit</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Create New Users</h4>

    {!! Form::open(['route' => 'user.profile.create', 'method' => 'POST', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::select('user_type', ['' => '--------- Select One -------', 'user' => 'User', 'admin' => 'Admin'], null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                    {{ Form::text('first_name', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                    {{ Form::text('last_name', null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="fileinput fileinput-new text-center pull-right" data-provides="fileinput" style="width:250px;">
                    <div class="fileinput-new thumbnail" style="width:160px;">
                        <img class="img-responsive" src="/images/avatar.png" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                    <div>
                        <span class="btn-round btn-rose btn-file btn-small">
                            <span class="fileinput-new">Add Photo</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="profile_image" />
                        </span>
                        <br />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group label-floating">
                    {{ Form::label('contact', 'Contact No.', ['class' => 'control-label']) }}
                    {{ Form::text('contact', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
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
            </div>
        </div>
        <button type="submit" class="btn btn-rose pull-right">Create User</button>
        <div class="clearfix"></div>
    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection