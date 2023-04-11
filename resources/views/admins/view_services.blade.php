@extends('admin')
@section('title', 'View Service Plans')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View {{ucfirst($type)}} Subscriptions</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
        <li class="active"> View {{ucfirst($type)}} Service Plans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Subscriptions</h3>

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
                  <th>Renewed On</th>
                  <th>Expires On</th>
                  <th>Payment Status</th>
                  <th>Status</th>
                  <th width=80>Actions</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($services as $package)
                <?php
                 $r++;
                 $mypack = App\Mypackage::where('user_id', $package->user_id)->orderBy('id', 'DESC')->first();
                 if(App\Package::find($mypack->package_id)){
                 $pack = App\Package::find($mypack->package_id);
                ?>

                <tr>
                  <td>{{$package->first_name.' '.$package->last_name}}</td>
                  <td>{{$package->account_number}}</td>
                  <td>{{$pack->package_name}}</td>
                  <td>${{number_format($pack->package_price, 2)}}</td>
                  <td>{{$mypack->actual_duration}}</td>
                  <td>${{number_format($mypack->amount_payable, 2)}}</td>
                  <td>{{$mypack->buy_date?date('d M Y', strtotime($mypack->buy_date)):''}}</td>
                  <td>{{$mypack->renew_date?date('d M Y', strtotime($mypack->renew_date)):''}}</td>
                  <td>{{$mypack->expires_on?date('d M Y', strtotime($mypack->expires_on)):''}}</td>
                  <td>{{$mypack->payment_status}}</td>
                  <td>
                    @if($mypack->status == 1)
                    <label class="label label-success">Active</label>
                    @elseif($mypack->status == 2)
                    <label class="label label-default">Expired</label>
                    @else
                    <label class="label label-warning">Inactive</label>
                    @endif
                  </td>
                  <td>
                    @if(count(App\Mypackage::where('user_id', $package->user_id)->get()) > 1)
                    <a href="/admin/view_user_packages/{{$package->user_id}}" title="Subscription History" class="label label-success"><i class="fa fa-list"></i></a>
                    @else
                    {{-- <a href="/admin/package/{{$mypack->id}}/details" title="Subscription Details" class="label label-info"><i class="fa fa-file-text"></i></a> --}}
                    @endif

                    @if($mypack->status == 0)
                    <a href="/admin/subscribe/{{$mypack->id}}/approve" title="Approve" class="label label-warning" onclick="return confirm('Are you sure you want to approve this subscription?');"><i class="fa fa-check"></i></a>
                    @endif
                    @if(App\Package::find($mypack->package_id)->duration == 'year' && $mypack->status == 1)
                    <a href="/admin/subscribe/{{$mypack->id}}/cancel" title="Cancel" class="label label-danger" onclick="return confirm('Are you sure you want to cancel this subscription?');"><i class="fa fa-close"></i></a>
                    @endif
                  </td>
                </tr>
                <?php } ?>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection