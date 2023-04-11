@extends('admin')
@section('title', 'View Service Plans')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View User Subscription Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
        <li class="active"> View User Subscription Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Subscription History</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            {{-- <div class="row">
              <div class="col-md-5 col-md-offset-10">
                   <a href="/view_vehicles" title="Vehicle Details" class="label label-success"><i class="fa fa-list"></i></a>
                    <a href="/view_vehicles" title="Vehicle Details" class="label label-info"><i class="fa fa-print"></i></a>
              </div>
              
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Fleet Owner</th>
                  <th>Account No.</th>
                  <th>Plan Name</th>
                  <th>Service Plan</th>
                  <th>Duration</th>
                  <th>Payment</th>
                  <th>Start From</th>
                  <th>Renewal Date</th>
                  <th>Expires On</th>
                  <th>Payment Status</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($services as $package)
                <?php
                 $r++;
                 // $mypack = App\Mypackage::where('user_id', $package->user_id)->first();
                 // $pack = App\Package::find($mypack->package_id);
                 // dd($pack);
                ?>

                <tr>
                  <td>{{$package->first_name.' '.$package->last_name}}</td>
                  <td>{{$package->account_number}}</td>
                  <td>{{$package->package_name}}</td>
                  <td>${{number_format($package->package_price, 2)}}</td>
                  <td>{{$package->actual_duration}}</td>
                  <td>${{number_format($package->amount_payable, 2)}}</td>
                  <td>{{$package->buy_date?date('d M Y', strtotime($package->buy_date)):''}}</td>
                  <td>{{$package->renew_date?date('d M Y', strtotime($package->renew_date)):''}}</td>
                  <td>{{$package->expires_on?date('d M Y', strtotime($package->expires_on)):''}}</td>
                  <td>{{$package->payment_status}}</td>
                  <td>
                    @if($package->status == 1)
                    <label class="label label-success">Active</label>
                    @elseif($package->status == 2)
                    <label class="label label-default">Expired</label>
                    @else
                    <label class="label label-warning">Inactive</label>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="/admin/package/{{$package->id}}/details" title="Subscription Details" class="label label-info"><i class="fa fa-file-text"></i></a> --}}
                    @if($package->status == 0)
                    {{-- <a href="/admin/subscribe/{{$package->id}}/approve" title="Approve" class="label label-warning" onclick="return confirm('Are you sure you want to approve this subscription?');"><i class="fa fa-check"></i></a> --}}
                    @endif
                  </td>
                </tr>

                @endforeach
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->

@endsection