@extends('admin')
@section('title', 'User Profile')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="rose">
                    <i class="material-icons">perm_identity</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Edit Profile -
                        <small class="category">Complete your profile</small>
                    </h4>

    {!! Form::model($profile, ['route' => ['admin.profile.update', $profile->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group label-floating">
                    {{ Form::label('first_name', 'First Name:', ['class' => 'control-label']) }}
                    {{ Form::text('first_name', $profile->first_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('last_name', 'Last Name:', ['class' => 'control-label']) }}
                    {{ Form::text('last_name', $profile->last_name, ['class' => 'form-control'])}}
                </div>
                <div class="form-group label-floating">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="width:250px;">
                    <div class="fileinput-new thumbnail" style="width:250px;">
                        <img src="/images/{{ (Auth::user()->image)? 'profile/'.Auth::user()->image : 'avatar.png' }}" alt="">
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
            <div class="col-md-5">
                <div class="form-group label-floating">
                    <label class="control-label">Contact No.</label>
                    <input type="text" class="form-control" value="{{ $profile->contact }}" name="contact">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group label-floating">
                    <label class="control-label">Date of Birth</label>
                    <input type="text" class="form-control datepicker" value="{{ $profile->dob }}" name="dob">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group label-floating">
                    <label class="control-label">Profession</label>
                    <input type="text" class="form-control" value="{{ $profile->job_title }}" name="job_title">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group label-floating">
                    <label class="control-label">Facebook Profile</label>
                    <input type="text" class="form-control" value="{{ $profile->facebook }}" name="facebook">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>National ID Card</label>
                    <div class="form-group label-floating">
                        <img src="" class="img-responsive" style="max-width:400px;" alt="">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
        <div class="clearfix"></div>
    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection