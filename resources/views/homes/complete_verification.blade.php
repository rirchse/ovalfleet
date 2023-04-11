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

    <div class="col-md-6 col-md-offset-3">
        <div class="col-md-12 col-sm-7 center-block sign-up-form">
          <div class="" style="border:1px solid #ddd; margin-bottom:15px;font-family:arial">
            <div class="col-md-12 register-logo" style="margin-top:10px;margin-bottom:15px;font-size:25px;font-weight:400;">Complete Verification</div>
            <div class="register-box-body" style="border-radius: 4px;">
              {{-- <p class="login-box-msg">Register a New Membership</p> --}}

              {!! Form::open(['route' => 'complete.verification', 'method' => 'POST', 'onsubmit' => 'return checkValidation()', 'name' => 'signup', 'id' => 'signup', 'files' => true]) !!}
              @if(!empty(Session::get('referral')))
              <input type="hidden" value="{{Session::get('referral')}}" name="referral">
              @endif
              <div class="col-md-6">
                <div class="form-group has-feedback">
                   {{ Form::text('address', null, ['class' => 'form-control req', 'placeholder'=>'Address', 'id' => 'address'])}}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-feedback">
                   {{ Form::text('city', null, ['class' => 'form-control req', 'placeholder'=>'City', 'id' => 'confirmpassword'])}}
                 </div>
               </div>
              <div class="col-md-6">
                <div class="form-group has-feedback">
                   {{ Form::text('state', null, ['class' => 'form-control req', 'placeholder'=>'State', 'id' => 'confirmpassword'])}}
                 </div>
               </div>
              <div class="col-md-6">
                 <div class="form-group has-feedback">
                  {{ Form::text('zip_code', null, ['class' => 'form-control', 'placeholder'=>'ZIP Code', 'id' => 'zip_code' ])}}
                 </div>
               </div>
              <div class="col-md-6">
                 <div class="form-group has-feedback">
                  {{ Form::text('country', 'USA', ['class' => 'form-control', 'placeholder'=>'Country', 'id' => 'country' ])}}
                 </div>
               </div>
               <div class="col-md-6">
                <div class="form-group has-feedback">
                   <p>Profile Image optional.</p>
                   {{ Form::file('image', null, ['class' => 'form-control req', 'placeholder'=>'VAT ID', 'id' => 'vat_id'])}}
                </div>
               </div>
               <div class="col-md-12">

                <div class="row">
                  <div class="col-xs-10" style="margin-bottom:10px;font-size:14px">
                    {{-- By clicking Sign Up, you have read and agree to our <a target="_blank" href="/service_terms">Privacy Policy and Service Terms.</a><br> --}}
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <!--google captcha-->
                    {!! htmlFormSnippet() !!}
                    <br>

                  </div>
                  <div class="col-xs-12 ">
                    <button type="submit" class="btn btn-submit btn-warning">Save</button>
                  </div>
                  <!-- /.col -->

                  <div class="col-sm-12" style="padding: 10px 15px;clear:both">
                    {{-- <a href="/login" class="text-center">I already have an account.</a> --}}
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
              <div class="clearfix"></div>
            </div><!-- /.form-box -->
          </div>
        </div>
  </div><!-- /.register-box -->
  <br>
</div>
</div><!--wrapper-->

<script type="text/javascript">
  var type = document.getElementById('type');
  var driver_license = document.getElementById('driver_license');
  var organization = document.getElementById('organization');
  type.addEventListener('change', change);
  function change() {
    if (type.value == 'Driver') {
      driver_license.style.display = 'block';
      driver_license.setAttribute('required', 'required');
      organization.style.display = 'none';
    } else{
      driver_license.style.display = 'none';
      driver_license.removeAttribute('required');
      organization.style.display = 'block';
    } 

    if (type.value == 'Fleet Owner') {
      vat_id.style.display = 'block';
      vat_id.setAttribute('required', 'required');
    }else{
      vat_id.style.display = 'none';
      vat_id.removeAttribute('required');
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