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
      <div class="col-md-4 col-sm-6 col-xs-8">
        <form action="{{ route('process.verify.account') }}" method="post" id="verification-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Verify bank account</h4>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-2 col-sm-4">$0.</div>
                        <div class="col-md-10 col-sm-8">
                          <input type="text" class="form-control" id="amount1" placeholder="Enter the first amount" name="amount1" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-2 col-sm-4">$0.</div>
                        <div class="col-md-10 col-sm-8">
                          <input type="text" class="form-control" id="amount2" placeholder="Enter the second amount" name="amount2" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                </div>
                <div class="clearfix"></div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-success pull-right" value="Verify">
                </div>
            </div>
        </form>

        {{-- <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Selected Plan</h4>
          </div>
        <table class="table">
          <tr>
            <th>Plan Name: </th>
            <td>{{$package->package_name}}</td>
          </tr>
        </table>
      </div> --}}
      
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
