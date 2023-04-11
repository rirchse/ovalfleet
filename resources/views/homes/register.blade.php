@extends('home')
@section('title', 'Sign up')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
.form-control{height: 30px; font-size: 14px;border-radius: 3px!important}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row" style="margin-top:90px;">
    <div class="alert alert-danger" id="alert_body" style="display:none;margin:0 auto;margin-bottom:15px;">
      <button type="button" class="close" aria-hidden="true" onclick="this.parentNode.style.display='none'">&times;</button>
      <strong>Error:</strong> <span id="alert_msg"></span>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="col-md-6 col-sm-7 center-block sign-up-form">
          <div class="" style="border:1px solid #ddd; margin-bottom:15px;font-family:arial">
            <div class="col-md-12 register-logo" style="margin-top:10px;margin-bottom:15px;font-size:25px;font-weight:400;">SIGN UP</div>
            <div class="register-box-body" style="border-radius: 4px;">
              {{-- <p class="login-box-msg">Register a New Membership</p> --}}

              {!! Form::open(['route' => 'register.new.user', 'method' => 'POST', 'onsubmit' => 'return checkValidation()', 'name' => 'signup', 'id' => 'signup']) !!}
              @if(!empty(Session::get('referral')))
              <input type="hidden" value="{{Session::get('referral')}}" name="referral">
              @endif
              <div class="col-md-5 col-sm-5">
                <div class="form-group has-feedback has-float-label">
                  {{ Form::text('first_name', null, ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'firstname'])}}
                  <label for="firstname">First Name</label>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                 <div class="form-group has-feedback has-float-label">
                   {{ Form::text('middle_name', null, ['class' => 'form-control', 'placeholder'=>' ', 'id' => 'middlename' ])}}
                   <label for="middlename">Middle I.</label>
                </div>
              </div>
              <div class="col-md-4 col-sm-4">
                 <div class="form-group has-feedback has-float-label">
                   {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder'=>' ', 'id' => 'lastname' ])}}
                   <label for="lastname">Last Name</label>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group has-feedback has-float-label">
                   {{ Form::email('email', null, ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'email'])}}
                   <label for="email">Email Address</label>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group has-feedback has-float-label">
                   {{ Form::text('contact', null, ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'contact'])}}
                   <label for="contact">Contact Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-feedback has-float-label">
                   {{ Form::password('password', ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'password'])}}
                   <label for="password">Password</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-feedback has-float-label">
                   {{ Form::password('password_confirmation', ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'confirmpassword'])}}
                   <label for="confirmpassword">Re-Enter Password</label>
                 </div>
               </div>
              <div class="col-md-6">
                <div class="form-group has-feedback has-float-label">
                   <select name="account_type" id="type" class="form-control" required>
                    {{-- <option value=""></option> --}}
                     <option value="Fleet Owner">I am a Fleet Owner</option>
                     <option value="Driver">I am a Driver</option>
                     <option value="Dispatcher">I am a Dispatcher</option>
                     <option value="Shipper">I am a Shipper</option>
                   </select>
                   {{-- <label>Account Type</label> --}}
                 </div>
               </div>
              <div class="col-md-6">
                 <div class="form-group has-feedback has-float-label">
                   {{ Form::text('driver_license', null, ['class' => 'form-control', 'placeholder' => ' ', 'id' => 'driver_license', 'style' => 'display:none'])}}
                   <label for="driver_license" id="drivli_label" style="display:none">Enter Driver\'s Licence Number</label>

                   {{ Form::text('organization', null, ['class' => 'form-control', 'placeholder'=>' ', 'id' => 'organization' ])}}
                   <label for="organization" id="orglabel">Company/Organization</label>
                 </div>
               </div>
               <div class="col-md-6">
                <div class="form-group has-feedback has-float-label">
                   {{ Form::text('vat_id', null, ['class' => 'form-control req', 'placeholder'=>' ', 'id' => 'vat_id'])}}
                   <label for="vat_id" id="vat_id_label">VAT/EIN or ITIN</label>
                </div>
               </div>
               <div class="col-md-12">
                 
                 <style type="text/css">
                 /*.service-terms{max-height: 110px;overflow: auto;border: 1px solid #ddd}
                 .service-terms h3{text-align: center;border-bottom: 1px solid #ddd;padding-bottom: 5px;margin-top: 5px;font-size: 16px}
                 .service-terms ul{padding-left: 25px}
                 .service-terms ul li{text-align: justify;padding-right: 10px;margin-bottom: 10px;font-size: 14px}*/
                 </style>
                 {{-- <div class="row">
                   <div class="col-md-12">
                     <div class="service-terms" style="background:#fff">
                      @include('homes.service-terms-text')
                     </div>
                   </div>
                 </div> --}}

                <div class="row">
                  <div class="col-xs-10" style="margin-bottom:10px;font-size:14px">
                    By clicking Sign Up, you have read and agree to our <a target="_blank" href="/service_terms">Privacy Policy and Service Terms.</a><br>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <!--google captcha-->
                    {!! htmlFormSnippet() !!}
                    <br>

                  </div>
                  <div class="col-xs-12 ">
                    <button type="submit" class="btn btn-submit btn-warning">Sign up</button>
                  </div>
                  <!-- /.col -->

                  <div class="col-sm-12" style="padding: 10px 15px;clear:both">
                    <a href="/login" class="text-center">I already have an account.</a>
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
              <div class="clearfix"></div>
            </div><!-- /.form-box -->
          </div>
        </div>
        <div class="col-md-6 col-sm-5 sign-up-text">
          @include('homes.signup-text')
        </div>
  </div><!-- /.register-box -->
  <br>
</div>
</div><!--wrapper-->

<script type="text/javascript">
  var type = document.getElementById('type');
  var driver_license = document.getElementById('driver_license');
  var drivli_label = document.getElementById('drivli_label');
  var organization = document.getElementById('organization');
  var orglabel = document.getElementById('orglabel');
  type.addEventListener('change', change);
  function change() {
    if (type.value == 'Driver') {
      driver_license.style.display = 'block';
      drivli_label.style.display = 'block';
      driver_license.setAttribute('required', 'required');
      organization.style.display = 'none';
      orglabel.style.display = 'none';
    } else{
      driver_license.style.display = 'none';
      drivli_label.style.display = 'none';
      driver_license.removeAttribute('required');
      organization.style.display = 'block';
      orglabel.style.display = 'block';
    } 

    if (type.value == 'Fleet Owner') {
      vat_id.style.display = 'block';
      vat_id.setAttribute('required', 'required');
      vat_id_label.style.display = 'block';
    }else{
      vat_id.style.display = 'none';
      vat_id.removeAttribute('required');
      vat_id_label.style.display = 'none';
    }
  }
</script>

<script>
//form validation
// var req = document.getElementsByClassName('req');
// for(var x = 0; x < req.length; x++){
//   if(req[x].value == ''){
//     req[x].style.border = '1px solid #f00';
//   }
// }
// console.log(req[0].className);

var signup = document.forms['signup'];
var alert_body = document.getElementById('alert_body');
var alert_msg = document.getElementById('alert_msg');
// console.log(signup['first_name'].value);
function error_alert(msg){
  alert_body.style.display = 'block';
  alert_msg.innerHTML = msg;
}
function checkValidation(){
  if(signup['first_name'].value == '') {
    error_alert('First name is required');
    return false;
  }
  if(signup['last_name'].value == '') {
    error_alert('Last name is required');
    return false;
  }

  if(signup['email'].value == '') {
    error_alert('Email is required');    
    return false;
  }

  if(signup['contact'].value == '' || signup['contact'].value.length > 10 || signup['contact'].value.length < 10){
    error_alert('Contact number should be 10 characters.')
    return false;
  }
  if(signup['password'].value == '' || signup['password'].value.length > 32 || signup['password'].value.length < 6){
    error_alert('Password should be from 8 to 32 characters. ')
    return false;
  }

  if(signup['account_type'].value == 'Driver' && signup['driver_license'].value == '' || signup['account_type'].value == 'Driver' && signup['driver_license'].value.length > 20){
    error_alert('Driver License should be max 20 characters. ')
    return false;
  }

  if(signup['account_type'].value == 'Fleet Owner' && signup['vat_id'].value == ''){
    error_alert('VAT ID field is required.');
    return false;
  }

  if(signup['agree'].checked == false) {
    error_alert('You have to agree to the service Terms by clicking on the checkbox in order to be able to use OvalFleet platform. If you do not agree to the service terms stated herein, <a href="/" style="font-size:18px;color:#800">exit now</a>. &nbsp; <span style="font-size:13px" class="btn btn-info btn-xs" onclick="this.parentNode.parentNode.style.display=\'none\'">Proceed</span>');
    return false;
  }
}

// //text validation
// var strings = "tom, tommy, tuba";
// if (new RegExp("\\b"+"tom"+"\\b").test(strings)) {
//   //
//   console.log('match!');
//   return false;
// }
</script>

@endsection