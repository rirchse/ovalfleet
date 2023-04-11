@extends('user')
@section('title', 'View Service Plans')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Service Plans</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Billing & Services</a></li>
        <li class="active"> View Service Plans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Service Plans</h3>

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
                  <th>Service Plan</th>
                  <th>Plan Charges</th>
                  <th>Subscription Date</th>
                  <th>Renewal Date</th>
                  {{-- <th>Expires On</th> --}}
                  <th>Payment Status</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($packages as $package)
                <?php $r++; ?>

                <tr>
                  {{-- <td>{{dd($package->duration)}}</td> --}}
                  <td>{{$package->package_name}}</td>
                  <td>${{number_format($package->package_price, 2)}}</td>
                  {{-- <td>${{number_format($package->amount_payable, 2)}}</td> --}}
                  <td>{{date('d M Y', strtotime($package->buy_date))}}</td>
                  <td>{{$package->buy_date?date('d M Y', strtotime($package->buy_date.'+1 '.$package->actual_duration)):''}}</td>
                  {{-- <td>{{date('d M Y', strtotime($package->expires_on))}}</td> --}}
                  <td>{{$package->payment_status}}</td>
                  <td>
                    @if($package->status == 1)
                    <label class="label label-success">Active</label>
                    @else
                    <label class="label label-warning">Inactive</label>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="/package/{{$package->id}}/details" title="package Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    <a href="/package/{{$package->id}}/edit" class="label label-warning" title="Edit package"><i class="fa fa-edit"></i></a>
                    <a href="/package/{{$package->id}}/delete" class="label label-danger" title="Delete package" onclick="return confirm('Are you sure you want to delete this package?');"><i class="fa fa-trash"></i></a>
                    {{-- <a href="#">Add Expenses</a> --}}

                    <a href="/select_package" class="label label-danger" title="Downgrade Package"><i class="fa fa-arrow-down"></i></a>
                    <a href="/select_package" class="label label-success" title="Upgrade Package"><i class="fa fa-arrow-up"></i></a>

                  </td>

                </tr>

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