@extends('user')
@section('title', 'Service Details')
@section('content')

<?php

  $user = Auth::user();
  $mypackage = DB::table('mypackages')->where('user_id', $user->id)->orderBy('id', 'DESC')->first();
  $notSubscribe = DB::table('subscriptions')->where('user_id', $user->id)->where('stripe_plan', $package->stripe_plan_id)->first();
?>
<style>
  .MyCardElement {
    height: 40px;
    padding: 10px 12px;
    width: 100%;
    color: #32325d;
    background-color: white;
    border: 1px solid transparent;
    border-radius: 4px;

    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }

  .MyCardElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }

  .MyCardElement--invalid {
    border-color: #fa755a;
  }

  .MyCardElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
</style>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Stripe Subscription</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('subscription.create') }}" method="post" id="subscription-form">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="form-group">
              <div class="card-header">
                  <label for="card-element">
                      Enter your credit card information
                  </label>
              </div>
              <div class="card-body">
                  <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
                  </div>
                  <!-- Used to display form errors. -->
                  <div id="card-errors" role="alert"></div>
                  <input type="hidden" name="plan" value="{{ $package->id }}" />
                  <input type="hidden" name="user_email" id="user_email" value="{{ Auth::user()->email }}" />
              </div>
          </div>
          <div class="card-footer">
              <button class="btn btn-info btn-md" type="submit">Card Payment</button>
          </div>
        </form>
      </div>
    </div>
    
  </div>
</div>
<div class="modal fade" id="achModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ovalfleet ACH Payment</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('ach.payment') }}" method="get" id="ach-payment-form">
          <div class="form-group">
            <label for="account_holder_name">ACCOUNT HOLDER NAME:</label>
            <input type="text" class="form-control" id="account_holder_name" placeholder="ENTER ACCOUNT HOLDER NAME" name="account_holder_name">
          </div>
           <div class="form-group">
            <label for="account_holder_type">ACCOUNT HOLDER TYPE:</label>
            <select name="account_holder_type" class="form-control">
              <option value="company">Company</option>
              <option value="individual">Individual</option>
            </select>
          </div>
          <div class="form-group">
            <label for="routing_number">ROUTING NUMBER:</label>
            <input type="text" class="form-control" id="routing_number" placeholder="ENTER ROUTING NUMBER" name="routing_number">
          </div>
          <div class="form-group">
            <label for="account_number">ACCOUNT NUMBER:</label>
            <input type="text" class="form-control" id="account_number" placeholder="ENTER ACCOUNT NUMBER" name="account_number">
          </div>
          <input type="hidden" name="package_id" value="{{ $package->id }}">
          <input type="submit" class="btn btn-success" value="Submit">
        </form>
      </div>
    </div>
    
  </div>
</div>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Service Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
      <li class="active">Details</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="row">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Service Plan Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
              <a href="/select_package" title="Choose Service Plans" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th width=120>Service Plan:</th>
                  <td>{{$package->package_name}}</td>
                </tr>
                <tr>
                  <th>Plan Charges:</th>
                  <th>${{number_format($package->package_price,2)}}</th>
                </tr>
                <tr>
                  <th>Duration</th>
                  <td>{{ucfirst($package->duration)}}</td>
                </tr>
                <tr>
                  <th>Max Dispatcher</th>
                  <td>{{$package->max_dispatcher}}</td>
                </tr>
                <tr>
                  <th>Max Driver</th>
                  <td>{{$package->max_driver}}</td>
                </tr>
                <tr>
                  <th>Started From</th>
                  <td>{{date('d M Y')}}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$package['details']}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          <div class="box-footer">
              <a href="{{route('bankPayment', $package->id)}}" class="btn btn-info btn-md pull-right">ACH Payment</a>
                    @if($package->duration != 'year')
                      @if($notSubscribe == null)
                        <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Card Payment</button>
                      @else
                        <form action="{{ route('unsubscription') }}" method="post" >
                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <input type="hidden" name="plan" value="{{ $package->id }}" />
                          <div class="card-footer">
                              <button class="btn btn-info btn-md" type="submit">Un-Subscribe</button>
                          </div>
                        </form>
                      @endif
                     @else
                     {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#YearlyPlanNotify">Get Plan</button> --}}
                     @endif
          </div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
      {{-- <div class="col-md-6"> --}}
        {{-- <div class="box box-primary"> --}}
          {{-- <div class="box-header with-border">
            <h4 class="box-title">Payment Information</h4>
          </div> --}}
          {{-- <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th width=120>Duration</th>
                  <td>{{$package->duration}}</td>
                </tr>
                <tr>
                  <th>Amount Payable</th>
                  <th>${{number_format($getpackage['payable'],2)}}</th>
                </tr>
                <tr>
                  <th>Started From</th>
                  <td>{{date('d M Y')}}</td>
                </tr>
                <tr>
                  <th>Expires On</th>
                  <td>{{date('d M Y', strtotime($getpackage['expdate']))}}</td>
                </tr>
                <tr>
                  <td colspan=2></td>
                </tr>
              </tbody>
            </table>
          </div> --}}
          {{-- <div class="box-footer"> --}}
            {{-- <div class="col-md-12"> --}}
            </div>
          {{-- </div> --}}
          <div class="clearfix"></div>
      {{-- </div> --}}
    </div><!--row-->
  </section><!-- /.content -->

  <div class="modal fade" id="YearlyPlanNotify" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Important!</h4>
        </div>
        <div class="modal-body">
          In order to continue giving our customers the quickest service and best attention an electronic invoice for <b>${{number_format($package->package_price, 2)}}</b> will be sent to <b>{{$user->email}}</b>, to pay via ACH. Once the ACH has been processed, your account will be marked “Active”, and you will be sent an email confirming receipt of payment for your records.
          You can check your account status at any time. Simply login to your account and navigate to “View Orders”. The order status will be visible from there.
          Please note, if it has been over 5 business days since you sent your ACH payment, and you have not received an email confirming payment has been received, please contact our support center by login to your account and navigate to Support and Submit a Ticket or Live Chat and our Billing Department will launch an investigation.<br>
          We appreciate your business.
          <br><br> Thank you <br> OvalFleet

          {{-- To get this yearly plan, please deposit <b>${{$package->package_price}}</b>  (discounted 15%) to OVALFLEET bank account# <b>79879 89798 7</b>. Then please contact support with your OvalFleet Account Number and the deposit slip for full system access.<br><br> Thank you <br> OvalFleet --}}
        </div>
        <div class="modal-footer">
          <a href="/subscription-yearly/{{$package->id}}" class="btn btn-success pull-left"><i class="fa fa-check"></i> Agree</a>
          <button class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>
   
@endsection

@section('scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    // Create a Stripe client.
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    // Create an instance of Elements.
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4'
        }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
    };
    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });
    // Handle form submission.
    var form = document.getElementById('subscription-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the user if there was an error.
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('subscription-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);
      // Submit the form
      form.submit();
    }
  </script>
@endsection
