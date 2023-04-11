@extends('home')
@section('title', 'Login')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-8 ">
      <div class="col-md-6 sign-up-form">
        <div class="login-box" style="margin-top:100px">
        <div class="login-logo">
          <h2>New Password</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Create New Password</p>

          {!! Form::open(['route' => 'user.login', 'method' => 'POST', 'role' => 'form' ]) !!}
            
            <div class="form-group has-feedback">
              {{ Form::password('new_password', ['class' => 'form-control', 'required' =>'', 'placeholder' => 'New Password'])}}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
              {{ Form::password('retype_new_password', ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Retype New Password'])}}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-12">
                @include('/partials.google_recaptcha')
                <br>
              </div>
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-submit">Login</button>
              </div>
            </div>
        </div>
        </div>
      </div>      
    </div>
  </div>
</div>
@endsection