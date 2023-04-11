<html>
<head>

</head>
<body>
    
        @if ($message = Session::get('success'))
  
            <p>{!! $message !!}</p>
       
        <?php Session::forget('success');?>
        @endif

        @if ($message = Session::get('error'))
       
            <p>{!! $message !!}</p>
        
        <?php Session::forget('error');?>
        @endif

    	<form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form"
          action="{!! URL::to('paypal') !!}">
    	  <div class="w3-container w3-teal w3-padding-16">Paywith Paypal</div>
    	  {{ csrf_field() }}
    	  <h2 class="w3-text-blue">Payment Form</h2>
    	  <p>Demo PayPal form - Integrating paypal in laravel</p>
    	  <label class="w3-text-blue"><b>Enter Amount</b></label>
    	  <input class="w3-input w3-border" id="amount" type="text" name="amount"></p>
    	  <button class="w3-btn w3-blue">Pay with PayPal</button>
    	</form>
    
</body>
</html>