@extends('home')
@section('title', 'Login')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-8">
      <div class="col-md-7 sign-up-form">
        <div class="login-box" style="margin-top:100px">
        <div class="login-logo">
          <h2>Reset Password</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Input your registered email address.</p>

          {!! Form::open(['route' => 'home.password.reset', 'method' => 'POST', 'role' => 'form' ]) !!}
            <div class="form-group has-feedback">
              {{ Form::email('email', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Email Address'])}}
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            {{-- <div class="form-group has-feedback">
              {{ Form::password('password', ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Password'])}}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div> --}}
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
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
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
          
      {{-- 
      <div class="col-md-7 sign-up-text" style="padding-top:100px">
        <div class="conent-text about-us" style="border:1px solid #ddd; padding: 15px;">
        <div class="">
          <span style="color: #023C5E;font-size:16px"><b>Welcome to OvalFleet</b></span><br>
        </div>
        <br>
        <p><b>Are you ready?</b><br>
          OvalFleet is built to simplify your workload so your pickup and delivery service will run smoothly.</p>
          <p><b>How we do it</b></br>
            By deploying the best-of-the-breed, secure smooth pickup, and delivery operations you can plan effectively and intelligently for your next shipment with OvalFleet.</p>
          </div>
          <div class="clearfix"></div>
          <style type="text/css">
            .main-item{float:left;padding:5px;width:25%;min-height: 70px;text-align: center;display: block;font-size: 14px;vertical-align: middle;}
            .main-item img{width: 100%}
            </style>
          <div class="customer_review" style="margin-top:25px; margin-bottom:15px; padding:0px 5px;dispaly:flex;flex-wrap:nowrap">
            
            {{-- <p><b style="font-size:16px;">CUSTOMER REVIEWS </b>
            <img src="/img/home/five-stars.png" width="100" alt="five stars"/></p>
            <p>I love OvalFleet services.<br>
              <b>- Rocky</b>
            </p>
            <div class="clearfix"></div> --}}
            {{-- 
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
              </div> --}}
            {{-- <div class="clearfix"></div> --}}
          </div> 
      </div>
      
    </div>
  </div>
</div>
@endsection