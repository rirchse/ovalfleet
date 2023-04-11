@extends('home')
@section('content')
<br><br>
<br><br>
<br><br>
<div class="col-md-6 col-md-offset-3">
{!! Form::open(['route' => 'login.byemail', 'method' => 'POST', 'role' => 'form' ]) !!}
            <div class="form-group has-feedback">
              {{ Form::email('email', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Email Address'])}}
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])}}
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
              <!-- /.col -->
            </div>
{!! Form::close() !!}
</div>
  @endsection