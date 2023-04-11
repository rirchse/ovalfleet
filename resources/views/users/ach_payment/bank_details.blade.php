@extends('user')
@section('title', 'Service Details')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>OvalFleet ACH Payment</h1>
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
            <form action="{{ route('ach.payment') }}" method="post" id="ach-payment-form">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Add Bank details</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="account_holder_name">ACCOUNT HOLDER NAME:</label>
                            <input type="text" class="form-control" id="account_holder_name" placeholder="ENTER ACCOUNT HOLDER NAME" name="account_holder_name" autocomplete="off">
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
                            <input type="text" class="form-control" id="routing_number" placeholder="ENTER ROUTING NUMBER" name="routing_number" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="account_number">ACCOUNT NUMBER:</label>
                            <input type="text" class="form-control" id="account_number" placeholder="ENTER ACCOUNT NUMBER" name="account_number" autocomplete="off">
                        </div>
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        <input type="hidden" name="user_email" id="user_email" value="{{ Auth::user()->email }}" />
                    </div>
                    <div class="clearfix"></div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success pull-right">Submit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>   
@endsection

@section('scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    //
  </script>
@endsection
