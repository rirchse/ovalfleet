@extends('home')
@section('title', 'Login')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">

<div class="login-box">
  <div class="login-logo">
    <h2>Admin Login</h2>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Access to Admin Panel</p>

    {!! Form::open(['route' => 'admin.login', 'method' => 'POST', 'role' => 'form' ]) !!}
      <div class="form-group has-feedback has-float-label">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {{ Form::email('email', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'email'])}}
        <label for="email">Email Address</label>
      </div>
      <div class="form-group has-feedback has-float-label">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {{ Form::password('password', ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'password'])}}
        <label for="password">Password</label>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <!--google captcha-->
          {!! htmlFormSnippet() !!}
          <br>
        </div>
        {{-- <div class="col-xs-8">
          <div class="checkbox icheck">
            <label class="">
              <input type="checkbox" class="checkbox"> Remember Me
            </label>
            <div class="clearfix"></div>
          </div>
        </div> --}}
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-submit">Login</button>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    {{-- <a href="#">I forgot my password</a><br> --}}
    {{-- <a href="/signup" class="text-center">Register a new membership</a> --}}

          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
      </div>
    </div>
  </div>
@endsection