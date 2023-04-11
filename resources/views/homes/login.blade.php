@extends('home')
@section('title', 'Login')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="col-md-5 sign-up-form">
        <div class="login-box" style="margin-top:100px">
        <div class="login-logo">
          <h2>Login</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Login to start your session</p>

          {!! Form::open(['route' => 'user.login', 'method' => 'POST', 'role' => 'form' ]) !!}
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
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Login using
              Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Login using
              Google+</a>
          </div> -->
          <!-- /.social-auth-links -->

          <a href="/create_password_reset" class="text-primary">I forgot my password</a>
          <br>
          <a href="/signup" class="text-center">Register a new account.</a>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      </div>
      <div class="col-md-7 sign-up-text" style="padding-top:100px">
        <div class="conent-text about-us" style="border:1px solid #ddd; padding: 15px;">
        <div style="margin-bottom:10px">
          <span style="color: #023C5E;font-size:16px"><b>Welcome to OvalFleet</b></span>
        </div>
        <p><b>Are you ready?</b><br>
          Unload your workload. A real-time dashboard because the success of all companies depends on the efficient running of its service delivery operations.</p>
          <p><b>How we do it</b></br>
            By deploying the best-of-the-breed, secure smooth pickup, and delivery operations you can plan effectively and intelligently for your next shipment with OvalFleet.</p>
          </div>
          <div class="clearfix"></div>
          <style type="text/css">
            .main-item{float:left;padding:0 15px;width:25%;min-height: 70px;text-align: center;display: block;font-size: 14px;vertical-align: middle;}
            .main-item img{width: 100%}
            </style>
          <div class="customer_review" style="margin-top:25px; margin-bottom:15px;dispaly:flex;flex-wrap:nowrap">

            <img src="/img/home/login-truck.jpg" alt="" class="img-responsive" style="width:100%; border:1px solid #ddd; padding: 5px"><br>
            
            {{-- <p><b style="font-size:16px;">CUSTOMER REVIEWS </b>
            <img src="/img/home/five-stars.png" width="100" alt="five stars"/></p>
            <p>I love OvalFleet services.<br>
              <b>- Rocky</b>
            </p>
            <div class="clearfix"></div> --}}
            
              <div class="main-item">
                <img src="/img/home/01.jpg">
              </div>
              <div class="main-item">
                <img src="/img/home/02.jpg">
              </div>
              <div class="main-item">
                <img src="/img/home/03.jpg">
              </div>
              <div class="main-item" style="margin-right:0">
                <img src="/img/home/04.jpg">
              </div>
            <div class="clearfix"></div>
          </div>
      </div>
      
    </div>
  </div>
</div>
@endsection